document.addEventListener('DOMContentLoaded', () => {
    const cart = {}; // Stores product_id: {name, price, quantity}
    const cartCount = document.getElementById('cart-count');
    const cartItemsList = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const goToReserveButton = document.getElementById('go-to-reserve');
    const reservationFormSection = document.getElementById('reservation-form-section');
    const reservationForm = document.getElementById('reservation-form');
    const goToWhatsappButton = document.getElementById('go-to-whatsapp');
    let productsData = [];

    // Fetch products from backend
    async function fetchProducts() {
        try {
            const response = await fetch('php/get_products.php');
            productsData = await response.json();
            renderCategories(productsData);
        } catch (error) {
            console.error('Error fetching products:', error);
        }
    }

    // Render categories and carousels
    function renderCategories(products) {
        const categoryList = document.getElementById('category-list');
        categoryList.innerHTML = '';

        const categories = {};
        products.forEach(product => {
            if (!categories[product.category]) {
                categories[product.category] = [];
            }
            categories[product.category].push(product);
        });

        for (const categoryName in categories) {
            const categorySection = document.createElement('div');
            categorySection.classList.add('category-section');
            categorySection.innerHTML = `
                <h3>${categoryName}</h3>
                <div class="carousel-container">
                    <button class="carousel-button prev">&lt;</button>
                    <div class="carousel" id="carousel-${categoryName.replace(/\s+/g, '-')}"></div>
                    <button class="carousel-button next">&gt;</button>
                </div>
            `;
            categoryList.appendChild(categorySection);

            const carousel = categorySection.querySelector(`#carousel-${categoryName.replace(/\s+/g, '-')}`);
            categories[categoryName].forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('product-card');
                productCard.innerHTML = `
                    <img src="${product.image_url}" alt="${product.name}">
                    <h4>${product.name}</h4>
                    <p>Bs${parseFloat(product.price).toFixed(2)}</p>
                    <button class="reserve-button" data-product-id="${product.id}">Reservar</button>
                `;
                carousel.appendChild(productCard);
            });

            setupCarousel(carousel, categories[categoryName].length);
        }
        addReserveButtonListeners();
    }

    // Setup infinite carousel
    function setupCarousel(carousel, totalItems) {
        const prevButton = carousel.previousElementSibling;
        const nextButton = carousel.nextElementSibling;
        let currentIndex = 0;
        const itemWidth = 300; // product-card width + margin (280 + 20)

        function updateCarousel() {
            carousel.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
        });
    }

    // Add event listeners for reserve buttons
    function addReserveButtonListeners() {
        document.querySelectorAll('.reserve-button').forEach(button => {
            button.addEventListener('click', (event) => {
                const productId = event.target.dataset.productId;
                addProductToCart(productId);
            });
        });
    }

    // Add product to cart
    function addProductToCart(productId) {
        const product = productsData.find(p => p.id == productId);
        if (product) {
            if (cart[productId]) {
                alert('Ya has reservado este producto.');
                return;
            }
            cart[productId] = { ...product, quantity: 1 };
            updateCartDisplay();
            alert(`${product.name} ha sido añadido a tu carrito de reservas.`);
        }
    }
    
    // Remove product from cart
    function removeFromCart(productId) {
        if (cart[productId]) {
            const productName = cart[productId].name;
            delete cart[productId];
            updateCartDisplay();
            alert(`${productName} ha sido eliminado del carrito.`);
        }
    }

    // Update cart display
    function updateCartDisplay() {
        let count = 0;
        let total = 0;
        cartItemsList.innerHTML = '';

        for (const productId in cart) {
            const item = cart[productId];
            count += item.quantity;
            total += item.price * item.quantity;

            const listItem = document.createElement('li');
            listItem.innerHTML = `
                <span>${item.name}</span>
                <div style="display: flex; align-items: center; gap: 1px;">
                    <span>Bs${parseFloat(item.price).toFixed(2)}</span>
                    <button 
  class="remove-item-btn" 
  data-product-id="${productId}" 
  style="
    background: #dc3545; 
    color: white; 
    border: none; 
    padding: 0 6px; /* menos padding horizontal */
    border-radius: 4px; 
    cursor: pointer; 
    font-size: 0.7em; 
    width: auto; /* asegura que el ancho sea automático */
    min-width: 20px; /* para que no sea demasiado pequeño */
    height: 20px; /* tamaño fijo para altura */
    line-height: 18px; /* alinea la X verticalmente */
    text-align: center; 
    display: inline-block; /* o inline-flex */
  "
>
  ✕
</button>

                </div>
            `;
            cartItemsList.appendChild(listItem);
        }

        cartCount.textContent = count;
        cartTotal.textContent = total.toFixed(2);

        if (count === 0) {
            cartItemsList.innerHTML = '<li>No hay productos en el carrito.</li>';
        }

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const productId = e.target.dataset.productId;
                removeFromCart(productId);
            });
        });
    }

    // Go to reserve button click
    goToReserveButton.addEventListener('click', () => {
        if (Object.keys(cart).length === 0) {
            alert('Tu carrito de reservas está vacío.');
            return;
        }
        // Hide other sections and show reservation form
        document.querySelector('header').style.display = 'none';
        document.getElementById('home').style.display = 'none';
        document.getElementById('categories').style.display = 'none';
        document.getElementById('about').style.display = 'none';
        document.querySelector('footer').style.display = 'none';
        reservationFormSection.style.display = 'block';
        window.scrollTo(0, 0); // Scroll to top
    });

    // Handle reservation form submission
    reservationForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const customerName = document.getElementById('customer-name').value;
        const customerEmail = document.getElementById('customer-email').value;
        const customerPhone = document.getElementById('customer-phone').value;
        const additionalNotes = document.getElementById('additional-notes').value;

        const reservations = Object.values(cart).map(item => ({
            product_id: item.id,
            product_name: item.name,
            price: item.price,
            customer_name: customerName,
            customer_email: customerEmail,
            customer_phone: customerPhone,
            additional_notes: additionalNotes
        }));

        try {
            const response = await fetch('php/make_reservation.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ reservations: reservations })
            });
            const result = await response.json();

            if (result.success) {
                alert('Reserva realizada con éxito!');
                goToWhatsappButton.style.display = 'block';
                goToWhatsappButton.dataset.reservationDetails = JSON.stringify(reservations);
                // Clear cart after successful reservation
                for (const key in cart) {
                    delete cart[key];
                }
                updateCartDisplay();
                reservationForm.reset();
            } else {
                alert('Error al realizar la reserva: ' + result.message);
            }
        } catch (error) {
            console.error('Error submitting reservation:', error);
            alert('Error de conexión al servidor.');
        }
    });

    // Go to WhatsApp button click
    goToWhatsappButton.addEventListener('click', () => {
        const reservationDetails = JSON.parse(goToWhatsappButton.dataset.reservationDetails);
        let message = `¡Hola! Quiero confirmar mi reserva en FashionLink.\n\n`;
        message += `Detalles del Cliente:\n`;
        message += `Nombre: ${reservationDetails[0].customer_name}\n`;
        message += `Email: ${reservationDetails[0].customer_email}\n`;
        message += `Teléfono: ${reservationDetails[0].customer_phone}\n\n`;
        message += `Productos Reservados:\n`;
        reservationDetails.forEach(item => {
            message += `- ${item.product_name} (Bs${parseFloat(item.price).toFixed(2)})\n`;
        });
        if (reservationDetails[0].additional_notes) {
            message += `\nNotas Adicionales: ${reservationDetails[0].additional_notes}\n`;
        }
        message += `\n¡Gracias!`;

        // Replace with the actual seller's WhatsApp number
        const whatsappNumber = '59177673615'; // CHANGE THIS: Replace with your WhatsApp number (country code + number, no + sign)
        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    });

    // Admin link functionality
    document.querySelector('a[href="#admin"]').addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = 'php/admin/index.php';
    });

    // Initial fetch
    fetchProducts();
    updateCartDisplay(); // Initialize cart display

    document.getElementById('back-to-home').addEventListener('click', () => {
        // Ocultar formulario
        reservationFormSection.style.display = 'none';

        // Mostrar secciones principales
        document.querySelector('header').style.display = 'block';
        document.getElementById('home').style.display = 'block';
        document.getElementById('categories').style.display = 'block';
        document.getElementById('about').style.display = 'block';
        document.querySelector('footer').style.display = 'block';

        // Hacer scroll al inicio
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

});