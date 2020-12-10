# ZERO-DOULEUR API

## Routes définies :

### Utilisateur

#### POST : 

* **/register** : Permet d'envoyer ses données d'inscription
```
Contenu à envoyer au format JSON : 

{
    "lastname" : "Nom de famille de l'utilisateur (string) (au moins 2 caractères)",
    "firstname" : "Prénom de l'utilisateur (string) (au moins 2 caractères)",
    "username" : "Nom d'utilisateur (string) (au moins 2 caractères),
    "email" : "Mail de l'utilisateur (string)",
    "agreeTerms" : "L'utilisateur accepte ou non les conditions d'utilisation (boolean)"
}

```

* **/login** : Permet d'envoyer ses données de connexion afin de recevoir un token d'authentification  
```
Contenu à envoyer au format JSON : 

{
    "username" : "Nom d'utilisateur (string)",
    "password" : "Mot de passe (string)"
} 
```

* **/api/session/{sessionId}/notation** : Permet d'envoyer une première notation du ressenti de l'utilisateur avant de commencer une session 
    * sessionId : Identifiant de la session (integer)
```
Contenu à envoyer au format JSON : 

{
    "preNotation" : "Première Notation du ressenti utilisateur (integer entre 0 et 10)
} 
```

#### PUT : 

* **/api/session/{sessionId}/notation** : Permet d'envoyer une seconde notation du ressenti de l'utilisateur après la session
    * sessionId : Identifiant de la session (integer)
```
Contenu à envoyer au format JSON : 

{
    "postNotation" : "Seconde Notation du ressenti utilisateur (integer entre 0 et 10),
    "postReview" : "Commentaires par rapport à la session (string)
} 
```

#### GET :

* **/api/sessions/start/{start}/offset/{offset}** : Permet de récupérer un certain nombre de sessions
    * start : Index de départ (integer)
    * offset : Nombre de sessions à récupérer à partir de l'index de départ 

* **/api/sessions/start/{start}/offset/{offset}/tag/{tag}** : Permet la même chose que le point précédent, mais ce dernier ajoute un filtre supplémentaire.
    * tag : Catégorie des sessions souhaités

* **/api/session/{idSession}** : Permet de récupérer le détail d'une session
    * idSession : Identifiant de la session (integer)

* **/static/media/{filename}** : Le serveur sert les fichiers médias via cet url
    * filename : Nom du fichier

### Administrateur : 

#### POST : 

* **/login** : Permet d'envoyer ses données de connexion afin de recevoir un token d'authentification 

```
Contenu à envoyer au format JSON :
{
    "username" : "Nom d'utilisateur (string)",
    "password" : "Mot de passe (string)"
}
```

* **/api/admin/session** : Permet de créer une nouvelle session 

```
Contenu à envoyer au format Form-Data (pour que le fichier puisse être envoyé) :

* title : Titre de la session (string) (min. 2 caractères)
* description :
* tag : 
* mediaFile : Fichier média qui servir de support à la session
```

* **/api/admin/session/{sessionId}** : Permet de modifier une session déjà existante
    * sessionId : Identifiant de la session (integer)
    
```
Contenu à envoyer au format Form-Data (pour que le fichier puisse être envoyé):

* title : Titre de la session (string) (min. 2 caractères)
* description : Description de la session (string)
* tag : Catégorie de la session 
* mediaFile : Fichier média qui servir de support à la session
```

*Ici l'API utilise le verbe HTTP POST pour la modification de la ressource au lieu du verbe PUT conventionnel : cela est dû à un bug de symfony qui ne détecte pas le contenu des champs envoyés*

#### DELETE : 

* **/api/admin/session/{sessionId}** : Permet de supprimer une session existante
    * sessionId : Identifiant de la session (integer)

#### GET :

* **/api/auth/report/{sessionId}** : Permet de récupérer les notes (ressentis) de tous les utilisateurs ayant participé à une session précise.
    * sessionId : Identifiant de la session (integer) 



