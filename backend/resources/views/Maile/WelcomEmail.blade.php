<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue dans la communauté SmartClass</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px; text-align: center;">
                <h2 style="color: #2c3e50;">Bienvenue dans la communauté SmartClass, {{$data['name']}} !</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Bonjour {{$data['name']}},</p>
                <p>Nous sommes très heureux de vous accueillir dans notre communauté éducative à <strong>SmartClass</strong> ! Notre mission est de vous offrir un environnement d'apprentissage optimal qui vous aidera à réaliser vos objectifs académiques et professionnels.</p>
                <h3>Comment commencer ?</h3>
                <ul>
                    <li><strong>Connexion :</strong> Connectez-vous à votre compte pour accéder à vos cours, exercices et autres outils pédagogiques.</li>
                </ul>
                <p><strong>Email :</strong> {{$data['email']}}</p>
                <p><strong>Mot de passe :</strong> {{$data['password']}}</p>
                <p>Nous vous recommandons de personnaliser votre mot de passe après votre première connexion pour garantir la sécurité de votre compte.</p>
                <p>Si vous avez des questions ou avez besoin d'assistance, notre équipe est là pour vous aider. N'hésitez pas à nous contacter à tout moment.</p>
                <p>Nous vous souhaitons un excellent début d'apprentissage sur SmartClass !</p>
                <p>Cordialement,<br>L'équipe SmartClass</p>
            </td>
        </tr>
    </table>
</body>
</html>