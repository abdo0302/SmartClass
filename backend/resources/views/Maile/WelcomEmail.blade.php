<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($data['role']=='eleve')
       <div>
        <img src="data:image/jpeg;base64,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" alt="">
       <h1>Sujet : Bienvenue à SmartClass</h1>
       <h6>Bonjour {{$data['name']}}</h6>
       <p>Nous sommes très heureux de vous accueillir dans notre communauté éducative à SmartClass ! Nous nous engageons à fournir un environnement d'apprentissage exceptionnel pour vous aider à atteindre vos objectifs académiques et professionnels.</p>
       <h4>Comment commencer</h4>
       <span>Connexion : Connectez-vous à votre compte en utilisant l'email et le mot de passe que vous avez créés.</span>
       <span>Commencer l'apprentissage : Commencez votre parcours éducatif et atteignez vos objectifs.</span>
       <span>Si vous avez besoin d'aide ou si vous avez des questions, n'hésitez pas à nous contacter par email à abdelljabarhamri06@gmail.com ou par téléphone au 0657892108.</span>
       <span>Bienvenue encore une fois à SmartClass, et nous vous souhaitons un parcours éducatif fructueux et plein de succès !</span>
       <h4>Cordialement,</h4>
    </div> 
    @else
    <div>
        <img src="data:image/jpeg;base64,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" alt="">
       <h1>Sujet : Bienvenue à SmartClass</h1>
       <h6>Bonjour {{$data['name']}}</h6>
       <p>Nous sommes très heureux de vous accueillir dans notre communauté éducative à SmartClass ! Nous nous engageons à offrir un environnement d'apprentissage exceptionnel qui soutient vos efforts en enseignement et vous aide à offrir une expérience éducative enrichissante et efficace à vos élèves.
       </p>
       <h4>Comment commencer</h4>
       <span><h5>Connexion :</h5> Connectez-vous à votre compte en utilisant l'email et le mot de passe que vous avez créés.</span>
       <span><h5>Configurer les cours :</h5> Créez et gérez vos cours et vos matériaux pédagogiques en toute simplicité.</span>
       <span>Si vous avez besoin d'aide ou si vous avez des questions, n'hésitez pas à nous contacter par email à abdelljabarhamri06@gmail.com ou par téléphone au 0657892108.</span>
       <span>Bienvenue encore une fois à SmartClass, et nous vous souhaitons un parcours éducatif fructueux et plein de succès !</span>
       <h4>Cordialement,</h4>
    </div>
    @endif
    
    
</body>
</html>