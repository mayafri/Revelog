Rêvelog est une application Web pour la journalisation, le classement et le partage de ses rêves.

L'application nécessite PHP 5.6 et MySQL ou MariaDB.

*Le projet n'en est qu'à ses tous débuts.*

# Structure de la base de données SQL

Les clés primaires (respectivement `id`, `id`, `name`, `fk_card`) sont Auto Increment
sauf la clé primaire `id` de revelog_Tags qui est une chaine.

```
revelog_Users → id login name pass

revelog_Cards → id title timestamp content narration emotion lucidity share fk_user
	narration [first | third | confused]
	emotion [positive | negative | confused]
	lucidity [yes | no | confused]
	share [private | public]
	
revelog_Tags → id category fk_card
	category [time | place | emotion | person | free]
```

# Syntaxe d'une fiche (champ "content")

Changement de temps

Changement de lieu

Changement de ton/émotion

Changement d'action

Changement de narration

Changement lucide
