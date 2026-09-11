# Guide de déploiement — OMRA TERANGA (Laravel + Next.js)

Guide **pas à pas** pour déployer la plateforme OMRA TERANGA sur un droplet
**DigitalOcean Ubuntu 22.04** où **Apache et MySQL sont déjà installés** et
servent déjà d'autres sites PHP.

> Toutes les commandes de ce guide sont du **bash**. Celles marquées
> **« local »** s'exécutent dans **Git-Bash sur ta machine Windows** ; celles
> marquées **« serveur »** s'exécutent dans le terminal SSH du droplet.

---

## 1. Ce qu'on déploie (architecture)

```
E:\projets\Omra\         → repo GitHub "omra-backend"
├── backend/  → Laravel 13 (PHP 8.3) + MoonShine 4   → API /api/*, admin /admin, images /storage
├── docs/     → ce guide
├── openspec/ → spécifications & changements
└── (assets image)

E:\projets\Omra\frontend/ → repo GitHub "omra-frontend"  (repo séparé)
└── Next.js 16 (React 19, Tailwind 4)                   → site public (SSR)
```

| Composant | Techno | Servi par | Rôle |
|-----------|--------|-----------|------|
| Backend   | Laravel 13, PHP ≥ 8.3, MySQL | Apache + **PHP 8.3-FPM** | API `/api/*`, admin `/admin`, images `/storage` |
| Frontend  | Next.js 16.2, Node ≥ 20.9 | serveur Node `next start` (systemd) | Site public (SSR) |
| Base de données | MySQL (base `omra`) | MySQL déjà installé | Données + sessions + cache + queue |

**Noms de domaine (adaptables) :**

```
oumrateranga.com  & www.oumrateranga.com  → frontend Next.js (reverse proxy Apache)
api.oumrateranga.com                      → backend Laravel  (document root = backend/public)
```

Le frontend appelle le backend côté serveur via 2 variables (voir
`frontend/src/lib/api.ts`) :

```
NEXT_PUBLIC_API_URL     = https://api.oumrateranga.com/api
NEXT_PUBLIC_STORAGE_URL = https://api.oumrateranga.com/storage
```

---

## 2. Prérequis

- Droplet Ubuntu 22.04, **2 GB RAM minimum (4 GB conseillé)** — le build Next.js est gourmand.
- Apache 2.4 + MySQL installés et actifs (tes autres sites PHP restent **intacts**).
- DNS : `oumrateranga.com`, `www.oumrateranga.com`, `api.oumrateranga.com` → IP du droplet.
- Comptes GitHub + éventuellement accès SSH configuré sur la machine locale.

**Versions requises par le code :**

| Dépendance | Version min. | Ubuntu 22.04 par défaut |
|------------|--------------|--------------------------|
| PHP (backend) | **8.3** | 8.1 ❌ (à installer via PPA) |
| Node.js (frontend) | **20.9** | aucun ❌ (à installer) |
| MySQL, Apache | n'importe | ✓ déjà installés |

> ⚠️ **Sécurité :** `mot-depasse-application.txt` et les `.env` ne doivent
> **jamais** être poussés sur GitHub — c'est déjà exclu par les `.gitignore`.

---

## 3. Phase A — Repos GitHub (depuis Git-Bash local)

### A.1 Repo backend (ce dossier racine)

Le repo racine couvre `backend/`, `docs/`, `openspec/` et les assets.
**Le dossier `frontend/` est déjà exclu** via `.gitignore` (il a son propre repo).

```bash
# Git-Bash sur Windows -> dossier racine
cd /e/projets/Omra

git init
git add -A
git status                      # vérifie : PAS de mot-depasse-application.txt, .env, node_modules

git commit -m "Initial commit: backend OMRA TERANGA (Laravel + MoonShine)"
git branch -M main
git remote add origin https://github.com/<ton-username>/omra-backend.git
git push -u origin main
```

**Contrôle sécurité** (aucune sortie = OK) :

```bash
git status --short | grep -Ei 'mot-depasse|\.env|vendor|node_modules'
```

### A.2 Repo frontend (séparé)

```bash
# Git-Bash sur Windows
cd /e/projets/Omra/frontend
git add -A
git commit -m "Init: frontend OMRA TERANGA (Next.js)"
git branch -M main
git remote add origin https://github.com/<ton-username>/omra-frontend.git
git push -u origin main
```

> Astuce git-bash : se souvient des identifiants via
> `git config --global credential.helper manager`.

---

## 4. Phase B — Préparer le serveur

### B.1 Connexion SSH

```bash
ssh root@<IP-du-droplet>        # ou ton user + sudo -i
```

### B.2 Mise à jour système

```bash
apt update && apt upgrade -y
apt install -y curl wget git zip unzip build-essential software-properties-common ca-certificates gnupg lsb-release
```

### B.3 Installer PHP 8.3 (SANS casser tes autres sites PHP)

Tes apps existantes tournent probablement avec le PHP d'Ubuntu (8.1) via
`mod_php` + Apache **mpm_prefork**. **Ne touche pas au mpm.** La nouvelle
version 8.3 s'installe comme FPM à côté et ne sert QUE le vhost de l'API.

```bash
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-xml php8.3-mbstring \
               php8.3-curl php8.3-zip php8.3-bcmath php8.3-intl php8.3-gd \
               php8.3-sqlite3 php8.3-bz2

php -v        # doit afficher 8.3.x (CLI)
systemctl enable --now php8.3-fpm
systemctl status php8.3-fpm
```

> ✅ **Aucune commande `a2dismod mpm_prefork`** — on garde le préfork réel
> pour tes applications actuelles ; le vhost Laravel utilisera
> `proxy:unix:/run/php/php8.3-fpm.sock` (compatible prefork).

### B.4 Modules Apache

```bash
a2enmod rewrite headers proxy proxy_http proxy_fcgi setenvif
systemctl restart apache2
```

### B.5 Composer

```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer --version
```

### B.6 Node.js 22 LTS

```bash
curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
apt install -y nodejs
node -v      # >= 22
npm -v
```

### B.7 Base MySQL + utilisateur

Sur Ubuntu, `root` MySQL s'authentifie en `auth_socket` → connection via `sudo`.

```bash
sudo mysql <<'EOF'
CREATE DATABASE IF NOT EXISTS omra
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'omra'@'localhost' IDENTIFIED BY 'CHANGE_ME_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON omra.* TO 'omra'@'localhost';
FLUSH PRIVILEGES;
EOF
```

Génère un mot de passe fort : `openssl rand -base64 24`. À conserver dans un
coffre ; il va uniquement dans le `.env` Laravel.

### B.8 Utilisateur de déploiement + dossier cible

```bash
useradd -m -s /bin/bash deploy
usermod -aG sudo deploy
mkdir -p /var/www/omra/backend /var/www/omra/frontend
chown -R deploy:deploy /var/www/omra
```

### B.9 Pare-feu (ufw)

```bash
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable
```

---

## 5. Phase C — Déployer le backend Laravel

### C.1 Clone + installation

```bash
# serveur
cd /var/www/omra/backend
sudo -u deploy git clone https://github.com/<ton-username>/omra-backend.git .

sudo -u deploy composer install --no-dev --optimize-autoloader
```

> `composer install` en tant que `deploy` → les fichiers ont le bon propriétaire
> pour l'étape d'ownership un peu plus loin.

### C.2 Fichier `.env`

```bash
cd /var/www/omra/backend
sudo -u deploy cp .env.example .env
```

Édite `.env` (`sudo -u deploy nano .env`). Changements minimaux :

```dotenv
APP_NAME="OMRA TERANGA"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.oumrateranga.com
APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=omra
DB_USERNAME=omra
DB_PASSWORD=CHANGE_ME_STRONG_PASSWORD

SESSION_DRIVER=database
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.ton-fournisseur.com
MAIL_PORT=587
MAIL_USERNAME=ton_smtp_user
MAIL_PASSWORD=ton_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@oumrateranga.com"
MAIL_FROM_NAME="${APP_NAME}"

NOTIFY_EMAIL=contact@oumrateranga.com
```

> Les variables `MOONSHINE_*` restent telles quelles.

### C.3 Clé, migrations, seed, liens

```bash
cd /var/www/omra/backend
sudo -u deploy php artisan key:generate
sudo -u deploy php artisan migrate --force
sudo -u deploy php artisan db:seed --force      # idempotent (firstOrCreate)

mkdir -p storage/app/public
sudo -u deploy php artisan storage:link
sudo -u deploy php artisan moonshine:user       # crée le compte admin /admin
```

> **Contenu saisi dans l'admin local** (FAQ, pages « à propos », images…)
> doit être recréé ici dans l'admin, **ou** transféré par export MySQL dédié
> (voir Phase H — optionnel).

### C.4 Droits d'écriture

```bash
cd /var/www/omra/backend
chown -R www-data:www-data storage bootstrap/cache public/storage
```

### C.5 Caches de prod

```bash
cd /var/www/omra/backend
sudo -u deploy php artisan config:cache
sudo -u deploy php artisan route:cache
sudo -u deploy php artisan view:cache
```

> Après chaque changement de `.env` : relancer `php artisan config:cache`.

### C.6 Vhost Apache de l'API

Crée `/etc/apache2/sites-available/api.oumrateranga.com.conf` :

```apache
<VirtualHost *:80>
    ServerName api.oumrateranga.com
    ServerAlias www.api.oumrateranga.com
    ServerAdmin webmaster@oumrateranga.com

    DocumentRoot /var/www/omra/backend/public

    <Directory /var/www/omra/backend/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # PHP 8.3-FPM (socket php8.3-fpm) — n'impacte PAS les autres vhosts
    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.3-fpm.sock|fcgi://localhost"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/omra-api-error.log
    CustomLog ${APACHE_LOG_DIR}/omra-api-access.log combined
</VirtualHost>
```

Active :

```bash
a2ensite api.oumrateranga.com
systemctl reload apache2
```

Teste (DNS déjà posé) :

```bash
curl -s http://api.oumrateranga.com/api/packages | head
# ou directement en local : curl -s http://127.0.0.1/api/packages -H "Host: api.oumrateranga.com"
```

Tu dois obtenir un tableau JSON. Demo admin : `http://api.oumrateranga.com/admin`.

---

## 6. Phase D — Déployer le frontend Next.js

### D.1 Clone + installation

```bash
cd /var/www/omra/frontend
sudo -u deploy git clone https://github.com/<ton-username>/omra-frontend.git .

sudo -u deploy npm ci
```

### D.2 Variables d'environnement (injectées au build)

Crée `/var/www/omra/frontend/.env.production.local` :

```dotenv
NEXT_PUBLIC_API_URL=https://api.oumrateranga.com/api
NEXT_PUBLIC_STORAGE_URL=https://api.oumrateranga.com/storage
```

### D.3 Build

```bash
cd /var/www/omra/frontend
sudo -u deploy npm run build
```

> Sur droplet < 2 GB :
> `NODE_OPTIONS=--max-old-space-size=2048 sudo -u deploy npm run build`

### D.4 Service systemd

Crée `/etc/systemd/system/omra-frontend.service` :

```ini
[Unit]
Description=OMRA TERANGA - Next.js frontend
After=network.target

[Service]
Type=simple
User=deploy
Group=deploy
WorkingDirectory=/var/www/omra/frontend
ExecStart=/usr/bin/npm run start -- -p 3000 -H 127.0.0.1
Restart=always
RestartSec=5
Environment=NODE_ENV=production

[Install]
WantedBy=multi-user.target
```

```bash
systemctl daemon-reload
systemctl enable --now omra-frontend
systemctl status omra-frontend --no-pager
ss -ltnp | grep 3000        # doit montrer 127.0.0.1:3000 (non exposé publiquement)
```

> `127.0.0.1` → le serveur Node n'est joignable QUE via Apache.

### D.5 Vhost Apache en reverse proxy (site public)

Crée `/etc/apache2/sites-available/oumrateranga.com.conf` :

```apache
<VirtualHost *:80>
    ServerName oumrateranga.com
    ServerAlias www.oumrateranga.com
    ServerAdmin webmaster@oumrateranga.com

    ProxyPreserveHost On
    ProxyRequests Off

    ProxyPass / http://127.0.0.1:3000/
    ProxyPassReverse / http://127.0.0.1:3000/

    <Location />
        Require all granted
    </Location>

    ErrorLog ${APACHE_LOG_DIR}/omra-web-error.log
    CustomLog ${APACHE_LOG_DIR}/omra-web-access.log combined
</VirtualHost>
```

```bash
a2ensite oumrateranga.com
systemctl reload apache2
```

Le site est en ligne sur `http://oumrateranga.com` (SSL ensuite).

> ⚠️ `mod_proxy` doit être activé (déjà fait en B.4). Si le site affiche
> `502 Proxy Error`, vérifie `systemctl status omra-frontend`.

---

## 7. Phase E — Certificats SSL (Let's Encrypt)

```bash
apt install -y certbot python3-certbot-apache

certbot --apache -d oumrateranga.com -d www.oumrateranga.com
certbot --apache -d api.oumrateranga.com
```

Certbot réécrit les vhosts pour le HTTPS et configure le renouvellement auto.

```bash
certbot renew --dry-run
systemctl list-timers | grep certbot
```

---

## 8. Phase F — Vérifications

| # | Test | Résultat attendu |
|---|------|------------------|
| 1 | `curl https://api.oumrateranga.com/api/packages` | JSON d'une liste de formules |
| 2 | `curl https://api.oumrateranga.com/api/site-settings` | JSON paramètres du site |
| 3 | `curl https://api.oumrateranga.com/api/faqs` | Liste des FAQ actives |
| 4 | `https://api.oumrateranga.com/admin` | Page de connexion MoonShine |
| 5 | Connexion admin (compte `moonshine:user`) | Dashboard OK |
| 6 | `https://oumrateranga.com` | Site public (SSR), images et logos OK |
| 7 | Page `/omra/omra-confort/...` | Données venues de l'API, accordéons FAQ OK |
| 8 | Soumettre le formulaire de réservation | Lead inséré en base |
| 9 | `systemctl status omra-frontend` | `active (running)` |
| 10 | `ufw status` | 22, 80, 443 autorisés |

---

## 9. Mise à jour (re-déploiement)

Après chaque push GitHub, sur le serveur :

```bash
set -e
# Backend
cd /var/www/omra/backend
sudo -u deploy git pull origin main
sudo -u deploy composer install --no-dev --optimize-autoloader
sudo -u deploy php artisan migrate --force
sudo -u deploy php artisan config:cache
sudo -u deploy php artisan route:cache
sudo -u deploy php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache public/storage
systemctl reload apache2

# Frontend (un changement de .env impose un nouveau build)
cd /var/www/omra/frontend
sudo -u deploy git pull origin main
sudo -u deploy npm ci
sudo -u deploy npm run build
systemctl restart omra-frontend
echo "Deploy OK"
```

Tu peux mettre ça dans `/usr/local/bin/omra-deploy` (chmod +x) pour l'appeler
à chaque mise à jour.

---

## 10. Maintenance

### 10.1 Cron Laravel

```bash
crontab -e -u deploy
# * * * * * cd /var/www/omra/backend && php artisan schedule:run >> /dev/null 2>&1
```

### 10.2 Sauvegarde base + fichiers uploadés

Créer `/usr/local/bin/omra-backup` :

```bash
#!/usr/bin/env bash
BACKUP=/var/backups/omra
mkdir -p "$BACKUP"
mysqldump -u omra -p'CHANGE_ME_STRONG_PASSWORD' omra | gzip > "$BACKUP/omra-$(date +%F_%H%M).sql.gz"
rsync -a --delete /var/www/omra/backend/storage/app/public/ "$BACKUP/uploads/"
find "$BACKUP" -name "*.sql.gz" -mtime +14 -delete
```

Cron quotidien : `0 3 * * * /usr/local/bin/omra-backup`

### 10.3 Logs utiles

```bash
tail -f /var/log/apache2/omra-api-error.log /var/log/apache2/omra-web-error.log
tail -f /var/www/omra/backend/storage/logs/laravel.log
journalctl -u omra-frontend -f
```

### 10.4 Rappels sécurité

- Jamais `.env`, `mot-depasse-application.txt`, clés SSH sur GitHub.
- `APP_DEBUG=false` en prod.
- `apt update && apt upgrade` régulier.
- Restreindre SSH à tes IP si possible.

---

## 11. Dépannage

| Symptôme | Cause probable | Correctif |
|----------|----------------|-----------|
| `502` / PHP téléchargé / page blanche sur l'API | FPM | `systemctl status php8.3-fpm`, socket `/run/php/php8.3-fpm.sock` conforme au vhost |
| Erreur 500 Laravel | caches/pki obsolètes ou droits | `chown -R www-data:www-data storage bootstrap/cache` ; `php artisan config:cache` |
| `.env` sans effet | cache de config | `php artisan config:clear` puis `cache` |
| 502/404 sur le site | Next.js down ou proxy inactif | `systemctl status omra-frontend` ; `a2enmod proxy proxy_http` |
| Images cassées | lien storage ou mauvaise URL | `php artisan storage:link` ; `NEXT_PUBLIC_STORAGE_URL` = `https://api.oumrateranga.com/storage` |
| `npm run build` tué | RAM insuffisante | `NODE_OPTIONS=--max-old-space-size=2048` ou augmenter RAM |
| Email non envoyé | SMTP | `php artisan tinker` → `Mail::raw('test', fn($m) => $m->to('x@y.fr')->send());` |

---

**Prêt quand :** la checklist de la Phase F passe, les certificats se renouvellent,
et un cycle de re-déploiement (Phase 9) a été testé de bout en bout.