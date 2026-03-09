# Rapport des modifications backend + frontend

Date: 2026-03-08

## Backend (`fonds-solidaire`)

### Fichier: `app/Http/Controllers/CotisationController.php`
- Ajout de la methode `totalAnnuel(Request $request)` pour corriger la route existante `/cotisations/total-annuel`.
- Alignement de `totalUser()` sur la regle metier: somme uniquement des cotisations `statut = validee`.
- Nettoyage de la reponse de creation et normalisation des messages.

### Fichier: `app/Http/Controllers/AuthController.php`
- `register()` retourne maintenant le code HTTP `201` apres creation de compte.
- Normalisation des messages de reponse (texte ASCII) pour eviter les problemes d'encodage.
- Leger reformatage de `logout()`.

### Fichier: `app/Http/Resources/CotisationResource.php`
- Ajout de la cle `date_cotisation` dans le JSON renvoye.
- Conservation de la cle `date` pour retro-compatibilite.

## Frontend (`fonds_solidaire_app`)

### Fichier: `lib/config/api_config.dart`
- `baseUrl` rendue configurable via `--dart-define API_BASE_URL`.
- Valeur par defaut alignee sur le backend local: `http://127.0.0.1:8000/api`.

### Fichier: `lib/services/auth_service.dart`
- Nettoyage des `print` de debug.
- Typage explicite de `register()`.
- Ajout de `logout(token)` qui appelle `POST /logout`.
- Gestion d'erreurs HTTP plus explicite.

### Fichier: `lib/services/cotisation_service.dart`
- Verification stricte des statuts HTTP sur toutes les methodes.
- Remontee du body d'erreur en cas d'echec de creation.
- Format de `date_cotisation` aligne (`YYYY-MM-DD`).
- Typage/robustesse ameliores.

### Fichier: `lib/services/dashboard_service.dart`
- Ajout de verification `statusCode` pour `/dashboard/global` et `/dashboard/mensuel`.
- Gestion d'erreur explicite en cas de reponse non-200.

### Fichier: `lib/services/user_service.dart`
- Ajout de verification `statusCode` pour `/user`.
- Retour type explicite + exceptions en cas d'echec.

### Fichier: `lib/screens/settings_screen.dart`
- La deconnexion appelle maintenant l'API backend (`AuthService.logout`) avant suppression du token local.
- Fallback securise: suppression locale du token meme si l'appel distant echoue.
- `loadUser()` protege par `try/catch` pour eviter un crash UI.

### Fichier: `lib/screens/add_cotisation_screen.dart`
- Validation frontend ajoutee: montant minimum `5000` (coherente avec le backend).
- Gestion d'erreur utilisateur lors de l'enregistrement.
- Messages normalises (ASCII) pour coherence d'encodage.

### Fichier: `lib/screens/register_screen.dart`
- Suppression d'un `print` de debug d'erreur d'inscription.

## Verification effectuee
- Verification syntaxique PHP:
  - `php -l app/Http/Controllers/AuthController.php` OK
  - `php -l app/Http/Controllers/CotisationController.php` OK
  - `php -l app/Http/Resources/CotisationResource.php` OK
- Formatage/verification Flutter non finalises (commandes `dart`/`flutter` ont expire dans cet environnement).
