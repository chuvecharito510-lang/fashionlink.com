<?php
require_once("auth.php");
requireAdminLogin();

// OBTENER CATEGORÍAS DESDE LA BASE DE DATOS
require_once("../../php/config.php");
$categories = [];
$sql_categories = "SELECT DISTINCT category FROM products ORDER BY category";
$result_categories = $conn->query($sql_categories);
if ($result_categories->num_rows > 0) {
    while($row = $result_categories->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}

if (isset($_GET["logout"])) {
    $conn->close();
    logoutAdmin();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FashionLink</title>
    <link rel="stylesheet" href="../../style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #fafafa;
            padding: 40px 20px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid rgba(0, 0, 0, 0.08);
            padding-bottom: 24px;
        }

        .dashboard-header h1 {
            margin: 0;
            color: #1a1a1a;
            font-size: 2.2em;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .header-buttons {
            display: flex;
            gap: 12px;
        }

        .logout-btn {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.95em;
            letter-spacing: 0.3px;
        }

        .logout-btn:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .product-form {
            background-color: #fafafa;
            padding: 32px;
            border-radius: 12px;
            margin-bottom: 40px;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .product-form h2 {
            margin: 0 0 32px 0;
            color: #1a1a1a;
            font-size: 1.6em;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.95em;
            letter-spacing: 0.3px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            font-size: 1em;
            background: #fff;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border: 2px solid #1a1a1a;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-buttons {
            display: flex;
            gap: 12px;
        }
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95em;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .btn-primary {
            background-color: #1a1a1a;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-success {
            background-color: #1a1a1a;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-warning {
            background-color: transparent;
            color: #666;
            border: 1px solid rgba(0, 0, 0, 0.15);
        }

        .btn-warning:hover {
            background-color: #f5f5f5;
            border-color: #1a1a1a;
            color: #1a1a1a;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        .products-list h2 {
            margin-bottom: 24px;
            color: #1a1a1a;
            font-size: 1.6em;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .products-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
        }

        .products-table th,
        .products-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .products-table th {
            background-color: #fafafa;
            font-weight: 700;
            color: #1a1a1a;
            font-size: 0.9em;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .products-table tr:last-child td {
            border-bottom: none;
        }

        .products-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .products-table tbody tr:hover {
            background-color: #fafafa;
        }

        .products-table img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }
        .message {
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95em;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn-secondary {
            background: transparent;
            color: #666;
            border: 1px solid rgba(0, 0, 0, 0.15);
        }

        .btn-secondary:hover {
            background: #f5f5f5;
            border-color: #1a1a1a;
            color: #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Panel Administrativo - FashionLink</h1>
            <div class="header-buttons">
                <a href="../../index.html" class="btn btn-secondary">Volver a la Tienda</a>
                <a href="?logout=1" class="logout-btn">Cerrar Sesión</a>
            </div>
        </div>

        <div id="message-container"></div>

        <div class="product-form">
            <h2>Agregar/Editar Producto</h2>
            <form id="product-form">
                <input type="hidden" id="product-id" name="product_id">
                
                <div class="form-group">
                    <label for="product-name">Nombre del Producto:</label>
                    <input type="text" id="product-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="product-description">Descripción:</label>
                    <textarea id="product-description" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="product-price">Precio:</label>
                    <input type="number" id="product-price" name="price" step="0.01" min="0" required>
                </div>

                <div class="form-group">
                    <label for="product-category">Categoría:</label>
                    <select id="product-category" name="category" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>">
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="product-image">URL de la Imagen:</label>
                    <input type="text" id="product-image" name="image_url" required>
                    <div id="image-preview" style="margin-top: 12px; display: none;">
                        <img id="preview-img" src="" alt="Vista previa" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(0, 0, 0, 0.15);">
                    </div>
                </div>

                <div class="form-group">
                    <label for="product-stock">Stock:</label>
                    <input type="number" id="product-stock" name="stock" min="0" value="1" required>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                    <button type="button" class="btn btn-warning" onclick="clearForm()">Limpiar Formulario</button>
                </div>
            </form>
        </div>

        <div class="products-list">
            <h2>Lista de Productos</h2>
            <table class="products-table" id="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="products-tbody">
                    <!-- Products will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let products = [];

        // Load products on page load
        document.addEventListener("DOMContentLoaded", () => {
            loadProducts();
        });

        // Load products from server
        async function loadProducts() {
            try {
                const response = await fetch("../../php/get_products.php");
                products = await response.json();
                renderProductsTable();
            } catch (error) {
                console.error("Error loading products:", error);
                showMessage("Error al cargar productos.", "error");
            }
        }

        // Render products table
        function renderProductsTable() {
            const tbody = document.getElementById("products-tbody");
            tbody.innerHTML = "";

            products.forEach(product => {
                const row = document.createElement("tr");
                const baseUrl = "/FashionLink/";
                const imgSrc = baseUrl + product.image_url;
                row.innerHTML = `
                    <td>${product.id}</td>
                    <td><img src="${imgSrc}" alt="${product.name}" onerror="this.src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMCAyMEg0MFY0MEgyMFYyMFoiIGZpbGw9IiNEMUQ1REIiLz4KPC9zdmc+\'"></td>
                    <td>${product.name}</td>
                    <td>Bs${parseFloat(product.price).toFixed(2)}</td>
                    <td>${product.category}</td>
                    <td>${product.stock}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editProduct(${product.id})">Editar</button>
                        <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Handle form submission
        document.getElementById("product-form").addEventListener("submit", async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const productData = Object.fromEntries(formData.entries());
            
            try {
                const response = await fetch("manage_products.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        action: productData.product_id ? "update" : "create",
                        product: productData
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, "success");
                    clearForm();
                    loadProducts();
                } else {
                    showMessage(result.message, "error");
                }
            } catch (error) {
                console.error("Error saving product:", error);
                showMessage("Error al guardar el producto.", "error");
            }
        });

        // Edit product
        function editProduct(productId) {
            const product = products.find(p => p.id == productId);
            if (product) {
                document.getElementById("product-id").value = product.id;
                document.getElementById("product-name").value = product.name;
                document.getElementById("product-description").value = product.description || "";
                document.getElementById("product-price").value = product.price;
                document.getElementById("product-category").value = product.category;
                document.getElementById("product-image").value = product.image_url;
                document.getElementById("product-stock").value = product.stock;

                // Show image preview
                updateImagePreview(product.image_url);

                // Scroll to form
                document.querySelector('.product-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Update image preview
        function updateImagePreview(imageUrl) {
            const imagePreview = document.getElementById("image-preview");
            const previewImg = document.getElementById("preview-img");

            if (imageUrl && imageUrl.trim() !== "") {
                previewImg.src = imageUrl;
                imagePreview.style.display = "block";

                // Handle image load error
                previewImg.onerror = function() {
                    imagePreview.style.display = "none";
                };
            } else {
                imagePreview.style.display = "none";
            }
        }

        // Listen to image URL input changes
        document.getElementById("product-image").addEventListener("input", function(e) {
            updateImagePreview(e.target.value);
        });

        // Delete product
        async function deleteProduct(productId) {
            if (!confirm("¿Estás seguro de que quieres eliminar este producto?")) {
                return;
            }

            try {
                const response = await fetch("manage_products.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        action: "delete",
                        product_id: productId
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, "success");
                    loadProducts();
                } else {
                    showMessage(result.message, "error");
                }
            } catch (error) {
                console.error("Error deleting product:", error);
                showMessage("Error al eliminar el producto.", "error");
            }
        }

        // Clear form
        function clearForm() {
            document.getElementById("product-form").reset();
            document.getElementById("product-id").value = "";
            document.getElementById("image-preview").style.display = "none";
        }

        // Show message
        function showMessage(message, type) {
            const container = document.getElementById("message-container");
            container.innerHTML = `<div class="message ${type}">${message}</div>`;
            setTimeout(() => {
                container.innerHTML = "";
            }, 5000);
        }
    </script>
</body>
</html>