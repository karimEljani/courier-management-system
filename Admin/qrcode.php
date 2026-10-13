<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Facture</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        #qrcode {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>QR Code Facture</h1>
    <p>Scannez le QR Code pour voir les détails de la facture</p>
    <div id="qrcode"></div>

    <script>
        // Détails de la facture
        const billData = {
            receiptID: "REC00123",
            customerName: "John Doe",
            date: new Date().toLocaleDateString(),
            totalAmount: "120.00 DT",
            paymentType: "Espèces",
            items: [
                { name: "Produit A", quantity: 1, price: "50.00 DT" },
                { name: "Produit B", quantity: 2, price: "35.00 DT" }
            ]
        };

        // Convertir les données en un texte pour le QR Code
        const qrData = `
Reçu #: ${billData.receiptID}
Client: ${billData.customerName}
Date: ${billData.date}
Montant Total: ${billData.totalAmount}
Paiement: ${billData.paymentType}
Articles:
${billData.items.map(item => `- ${item.name} x${item.quantity} : ${item.price}`).join("\n")}
        `;

        // Conteneur pour le QR Code
        const qrContainer = document.getElementById('qrcode');

        // Générer le QR Code
        QRCode.toDataURL(qrData, {
            width: 200, // Largeur du QR Code
            margin: 2,  // Marges autour du QR Code
            color: {
                dark: "#000000",  // Couleur du QR Code
                light: "#ffffff"  // Couleur de fond
            }
        }).then(url => {
            // Créer une image à partir de l'URL générée
            const img = document.createElement('img');
            img.src = url;
            img.alt = "QR Code";
            qrContainer.appendChild(img);

            // Envoyer l'URL du QR Code au serveur pour l'ajouter au PDF
            fetch('getbill.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ qrCodeUrl: url })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log("QR Code ajouté au PDF");
                } else {
                    console.error("Erreur lors de l'ajout du QR Code au PDF");
                }
            })
            .catch(error => console.error("Erreur réseau:", error));
        }).catch(error => {
            console.error("Erreur lors de la génération du QR Code :", error);
        });
    </script>
</body>
</html>
