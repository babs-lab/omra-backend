## 1. Backend — Modèle & Migration Currency

- [x] 1.1 Créer la migration `create_currencies_table` avec colonnes : `code` (string), `name` (string), `symbol` (string), `exchange_rate` (decimal), `is_active` (boolean, default true)
- [x] 1.2 Créer la migration pour ajouter `currency_id` (nullable, foreignId) à la table `packages`
- [x] 1.3 Créer le modèle `App\Models\Currency` avec `$fillable`, `casts`, et scope `active()`

## 2. Backend — MoonShine Resource Currency

- [x] 2.1 Créer `App\MoonShine\Resources\CurrencyResource` avec `ModelResource`, champs `Text` (code, name, symbol), `Number` (exchange_rate), `Switcher` (is_active)
- [x] 2.2 Enregistrer le resource dans `MoonShineServiceProvider`
- [x] 2.3 Ajouter "Devises" au sidebar admin dans `MoonShineLayout`

## 3. Backend — API Endpoint

- [x] 3.1 Créer `App\Http\Controllers\Api\CurrencyController` avec méthode `index()` retournant les devises actives
- [x] 3.2 Ajouter la route `GET /api/currencies` dans `routes/api.php`
- [x] 3.3 Mettre à jour `PackageController` pour inclure la relation `currency` dans les réponses API (`currency: { code, symbol }` ou null)
- [x] 3.4 Les suppléments sont globaux (pas de package parent) — la devise est appliquée côté frontend

## 4. Frontend — Type & API Client

- [x] 4.1 Ajouter l'interface `Currency` dans `frontend/src/types/index.ts`
- [x] 4.2 Mettre à jour l'interface `Package` pour inclure `currency: { code: string; symbol: string } | null`
- [x] 4.3 Ajouter la fonction `fetchCurrencies()` dans `frontend/src/lib/api.ts`

## 5. Frontend — Affichage dynamique des devises

- [x] 5.1 Créer un helper `formatPrice(amount: number, currency: { code: string; symbol: string } | null): string` dans `frontend/src/lib/format.ts`
- [x] 5.2 Mettre à jour `PackageCard` pour utiliser `formatPrice` avec la devise du package
- [x] 5.3 Mettre à jour `PricingTable` pour utiliser `formatPrice` avec la devise du package
- [x] 5.4 Mettre à jour `BookingForm` pour utiliser `formatPrice` avec la devise du package
- [x] 5.5 Mettre à jour la page `omra/[slug]/page.tsx` pour utiliser `formatPrice`

## 6. Seeds

- [x] 6.1 Créer un seeder `CurrencySeeder` avec EUR (code: EUR, nom: Euro, symbole: €, taux: 1.0, actif) et USD (code: USD, nom: Dollar US, symbole: $, taux: 1.08, actif)
- [x] 6.2 Mettre à jour `DatabaseSeeder` pour associer EUR aux packages existants
