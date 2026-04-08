# Schema-Per-Tenant PoC Notes

## Objective

Demonstrate true PostgreSQL schema isolation using Laravel 11 and `stancl/tenancy` before moving into feature development.

## Expected proof

- tenant A data lives in schema `tenant_alpha`
- tenant B data lives in schema `tenant_bravo`
- same logical tables exist in both schemas
- no request scoped to tenant A can read or mutate tenant B data
- automated test proves the isolation behavior

## Proposed implementation outline

1. Store tenant registry and domains in the central schema.
2. On tenant creation, create a PostgreSQL schema named from the tenant key.
3. Run tenant migrations against the new schema.
4. Resolve the tenant from subdomain or custom domain.
5. Switch PostgreSQL `search_path` for the request lifecycle.

## Example tenancy configuration

```php
// config/tenancy.php
'tenant_database_connection_name' => 'tenant',
'database' => [
    'central_connection' => 'pgsql',
    'template_tenant_connection' => 'tenant',
    'managers' => [
        'pgsql' => Stancl\Tenancy\TenantDatabaseManagers\PostgreSQLSchemaManager::class,
    ],
],
```

## Example connection idea

```php
// config/database.php
'connections' => [
    'pgsql' => [
        'driver' => 'pgsql',
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'search_path' => 'public',
    ],
    'tenant' => [
        'driver' => 'pgsql',
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'search_path' => 'public',
    ],
],
```

At runtime, tenancy bootstrappers update the tenant connection `search_path` to the active tenant schema.

## Isolation test shape

```php
it('isolates tenant data by schema', function () {
    $alpha = Tenant::create(['id' => 'alpha']);
    $alpha->domains()->create(['domain' => 'alpha.compoundx.test']);

    $bravo = Tenant::create(['id' => 'bravo']);
    $bravo->domains()->create(['domain' => 'bravo.compoundx.test']);

    tenancy()->initialize($alpha);
    User::create(['name' => 'Alpha Admin', 'email' => 'alpha@example.com']);

    tenancy()->initialize($bravo);
    expect(User::count())->toBe(0);
});
```

## PoC acceptance checklist

- host-based tenant resolution works
- tenant migrations can be rerun safely
- background jobs preserve tenant context
- cache keys include tenant scope where required
- automated tests fail if schema switch is missing
