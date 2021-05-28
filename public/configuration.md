NOTICES DE CONCEPTION
=
***

La plateforme se connecte a deux base de données pour non seulement verifier les utilisateurs selon leurs fonctions mais aussi pour recuperér les informations relatives aux adherants.


1.Configuration de doctrine
-
https://symfony.com/doc/current/doctrine/multiple_entity_managers.html

_config/packages/doctrine.yaml_
>
     doctrine:
         dbal:
             default_connection: default
             connections:
                 default:
                     # base de données par defaut
                     url: '%env(resolve:DATABASE_URL)%'
                     driver: 'pdo_mysql'
                     server_version: '5.7'
                     charset: utf8mb4
                 sygesca:
                     # Base de données de SYGESCA 3
                     url: '%env(resolve:DATABASE_CUSTOMER_URL)%'
                     driver: 'pdo_mysql'
                     server_version: '5.7'
                     charset: utf8mb4
     
             # IMPORTANT: You MUST configure your server version,
             # either here or in the DATABASE_URL env var (see .env file)
             #server_version: '13'
         orm:
             default_entity_manager: default
             entity_managers:
                 default:
                     connection: default
                     mappings:
                         App:
                             is_bundle: false
                             type: annotation
                             dir: '%kernel.project_dir%/src/Entity'
                             prefix: 'App\Entity'
                             alias: App
                 sygesca:
                     connection: sygesca
                     mappings:
                         Sygesca:
                             is_bundle: false
                             type: annotation
                             dir: '%kernel.project_dir%/src/Entity/Sygesca'
                             prefix: 'App\Entity\Sygesca'
                             alias: Sygesca

_config/packages/prod/doctrine.yaml_
>
    doctrine:
        orm:
            default_entity_manager: default
            customer_entity_manager: syesca
            auto_generate_proxy_classes: false
            metadata_cache_driver:
                type: pool
                pool: doctrine.system_cache_pool
            query_cache_driver:
                type: pool
                pool: doctrine.system_cache_pool
            result_cache_driver:
                type: pool
                pool: doctrine.result_cache_pool
    
    framework:
        cache:
            pools:
                doctrine.result_cache_pool:
                    adapter: cache.app
                doctrine.system_cache_pool:
                    adapter: cache.system


_.env_
>
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
    DATABASE_CUSTOMER_URL="mysql://custom_db_user:custom_db_password@127.0.0.1:3306/custom_db_name?serverVersion=5.7"

    ###> Fixation de la region concernée  ###
    REGION="NOM_REGION"
    ###< Fixation de la region concernée ###


2.Importation de
=
**1. Importation de entity**
>
    _php bin/console doctrine:mapping:import "App\Entity\Sygesca" --em=sygesca annotation --path=src/Entity/Sygesca_

    _symfony console doctrine:mapping:import "App\Entity\Sygesca" --em=sygesca annotation --filter="Scout" --path=src/Entity/Sygesca_

**2. Generation des Getters & Setters**
>
    php bin/console make:entity --regenerate App 

**3. Gestion de la migration**
>
    _symfony console make:migration_

    _symfony console doctrine:migrations:migrate_
