<!DOCTYPE html>
<html>
<head>
    <title>Envío de Remesas</title>
</head>
<body>
    <h1>Enviar Dinero</h1>
    <form id="remesaForm">
        <!-- Remitente -->
        <input type="text" placeholder="Nombre remitente" id="remitente" required>
        <input type="file" id="documentoKYC" accept=".pdf,image/*">
        
        <!-- Destinatario -->
        <input type="text" placeholder="Cuenta Stellar/Banco" id="destinatario" required>
        
        <!-- Monto -->
        <input type="number" placeholder="Monto" id="monto" required>
        <select id="monedaOrigen">
            <option>USD</option>
            <option>MXN</option>
            <option>EUR</option>
        </select>
        
        <button type="submit">Enviar</button>
    </form>

    <script>
        document.getElementById("remesaForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            
            // Convertir documento a Base64
            const documento = await toBase64(document.getElementById("documentoKYC").files[0]);
            
            // Enviar datos a n8n
            const response = await fetch("URL_WEBHOOK_N8N", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    remitente: document.getElementById("remitente").value,
                    documento: documento,
                    destinatario: document.getElementById("destinatario").value,
                    monto: document.getElementById("monto").value,
                    moneda: document.getElementById("monedaOrigen").value
                })
            });
            
            alert(await response.text());
        });

        // Función para convertir archivo a Base64
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result.split(",")[1]);
            reader.onerror = error => reject(error);
        });
    </script>
</body>
</html>
