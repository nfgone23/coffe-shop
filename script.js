// Массив корзины
let cart = [];

// Функция подсчета суммы (стрелочная)
const calculateTotal = () => {
    let sum = 0;
    for (let i = 0; i < cart.length; i++) {
        sum = sum + cart[i].price;
    }
    return sum;
};

// Показать корзину на странице
function showCart() {
    let cartDiv = document.getElementById('cart-list');
    let totalDiv = document.getElementById('total-price');
    
    if (!cartDiv) return;
    
    if (cart.length === 0) {
        cartDiv.innerHTML = '<p>Корзина пуста</p>';
        totalDiv.innerHTML = 'Итого: 0 ₽';
        return;
    }
    
    let html = '';
    for (let i = 0; i < cart.length; i++) {
        html = html + '<div class="cart-item">';
        html = html + '<span>' + cart[i].name + '</span>';
        html = html + '<span>' + cart[i].price + ' ₽</span>';
        html = html + '<button onclick="removeFromCart(' + i + ')">Удалить</button>';
        html = html + '</div>';
    }
    cartDiv.innerHTML = html;
    totalDiv.innerHTML = 'Итого: ' + calculateTotal() + ' ₽';
}

// Добавление в корзину
function addToCart(name, price) {
    cart.push({ name: name, price: price });
    showCart();
    alert(name + ' добавлен в корзину!');
}

// Удаление из корзины
function removeFromCart(index) {
    let removed = cart[index].name;
    cart.splice(index, 1);
    showCart();
    alert(removed + ' удален из корзины');
}

// Очистка корзины
function clearCart() {
    if (cart.length === 0) {
        alert('Корзина уже пуста');
        return;
    }
    cart = [];
    showCart();
    alert('Корзина очищена');
}

// Оплата
function checkout() {
    if (cart.length === 0) {
        alert('Ошибка: корзина пуста!');
        return;
    }
    alert('Оплата прошла успешно! Сумма: ' + calculateTotal() + ' ₽. Спасибо за покупку!');
    cart = [];
    showCart();
}

// Фильтр товаров
function initFilter() {
    let filterSelect = document.getElementById('filter');
    if (!filterSelect) return;
    
    filterSelect.addEventListener('change', function() {
        let selected = filterSelect.value;
        let products = document.querySelectorAll('.product');
        
        for (let i = 0; i < products.length; i++) {
            let category = products[i].getAttribute('data-category');
            if (selected === 'all' || category === selected) {
                products[i].style.display = 'block';
            } else {
                products[i].style.display = 'none';
            }
        }
    });
}

// Запуск при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    showCart();
    initFilter();
    
    let clearBtn = document.getElementById('clear-cart');
    if (clearBtn) {
        clearBtn.addEventListener('click', clearCart);
    }
    
    let payBtn = document.getElementById('pay-btn');
    if (payBtn) {
        payBtn.addEventListener('click', checkout);
    }
    
    // Кнопки "В корзину" на странице каталога
    let addButtons = document.querySelectorAll('.add-btn');
    for (let i = 0; i < addButtons.length; i++) {
        addButtons[i].addEventListener('click', function() {
            let name = this.getAttribute('data-name');
            let price = parseInt(this.getAttribute('data-price'));
            addToCart(name, price);
        });
    }
});