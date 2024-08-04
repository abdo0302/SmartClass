<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Bonjour {{ $data["nameEleve"] }}</h2>
    <p>Vous avez été inscrit avec succès dans Class {{ $data["mameClass"] }} Par le professeur {{ $data["nameProfesseur"] }}</p>
    <br/>
    <span>Merci</span>
</body>
</html>