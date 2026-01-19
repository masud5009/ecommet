@extends('user.layout')
@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('POS') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('user-dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('POS') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Side - Products -->
                        <div class="col-lg-7 col-md-6">
                            <div class="pos-products-section">
                                <!-- Search & Filter -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <input type="text" id="product-search" class="form-control"
                                            placeholder="{{ __('Search products...') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select id="category-filter" class="form-control">
                                            <option value="">{{ __('All Categories') }}</option>
                                            @foreach ($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Products Grid -->
                                <div class="products-grid" style="max-height: 600px; overflow-y: auto;">
                                    <div class="row" id="products-container">
                                        @forelse($products ?? [] as $product)
                                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3 product-item"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->title }}"
                                                data-product-price="{{ $product->current_price }}"
                                                data-category-id="{{ $product->category_id }}">
                                                <div class="card product-card" style="cursor: pointer;">
                                                    <img src="{{ isset($product->thumbnail) ? asset('assets/front/img/user/items/thumbnail/' . $product->thumbnail) : asset('assets/admin/img/noimage.jpg') }}"
                                                        class="card-img-top" alt="{{ $product->title }}"
                                                        style="height: 120px; object-fit: cover;">
                                                    <div class="card-body p-2">
                                                        <h6 class="card-title mb-1" style="font-size: 13px;">
                                                            {{ Str::limit($product->title, 30) }}</h6>
                                                        <p class="text-primary mb-0 font-weight-bold">
                                                            {{ $currency_symbol ?? '$' }}{{ number_format($product->current_price, 2) }}
                                                        </p>
                                                        @if ($product->stock > 0)
                                                            <small class="text-success">{{ __('In Stock') }}:
                                                                {{ $product->stock }}</small>
                                                        @else
                                                            <small class="text-danger">{{ __('Out of Stock') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <p class="text-center text-muted">{{ __('No products found') }}</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Cart & Checkout -->
                        <div class="col-lg-5 col-md-6">
                            <div class="pos-cart-section">
                                <!-- Customer Selection -->
                                <div class="mb-3">
                                    <label>{{ __('Customer') }}</label>
                                    <select id="customer-select" class="form-control">
                                        <option value="">{{ __('Walk-in Customer') }}</option>
                                        @foreach ($customers ?? [] as $customer)
                                            <option value="{{ $customer->id }}" data-email="{{ $customer->email }}"
                                                data-phone="{{ $customer->phone }}">
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cart Items -->
                                <div class="cart-items mb-3"
                                    style="max-height: 350px; overflow-y: auto; border: 1px solid #eee; padding: 10px;">
                                    <div id="cart-items-container">
                                        <p class="text-center text-muted">{{ __('Cart is empty') }}</p>
                                    </div>
                                </div>

                                <!-- Cart Summary -->
                                <div class="cart-summary mb-3 p-3" style="background: #f8f9fa; border-radius: 5px;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Subtotal') }}:</span>
                                        <span id="subtotal"
                                            class="font-weight-bold">{{ $currency_symbol ?? '$' }}0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Tax') }} (<span id="tax-percentage">0</span>%):</span>
                                        <span id="tax-amount">{{ $currency_symbol ?? '$' }}0.00</span>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>{{ __('Discount') }} (%)</label>
                                        <input type="number" id="discount-input" class="form-control" min="0"
                                            max="100" value="0" step="0.01">
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Discount Amount') }}:</span>
                                        <span id="discount-amount">{{ $currency_symbol ?? '$' }}0.00</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <h5>{{ __('Total') }}:</h5>
                                        <h5 id="total-amount" class="text-primary">{{ $currency_symbol ?? '$' }}0.00</h5>
                                    </div>
                                </div>

                                <!-- Payment Section -->
                                <div class="payment-section mb-3">
                                    <label>{{ __('Payment Method') }}</label>
                                    <select id="payment-method" class="form-control mb-2">
                                        <option value="cash">{{ __('Cash') }}</option>
                                        <option value="card">{{ __('Card') }}</option>
                                        <option value="mobile">{{ __('Mobile Banking') }}</option>
                                    </select>

                                    <label>{{ __('Amount Received') }}</label>
                                    <input type="number" id="amount-received" class="form-control mb-2" min="0"
                                        step="0.01" placeholder="0.00">

                                    <div class="d-flex justify-content-between">
                                        <span>{{ __('Change') }}:</span>
                                        <span id="change-amount"
                                            class="text-success font-weight-bold">{{ $currency_symbol ?? '$' }}0.00</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" id="clear-cart-btn" class="btn btn-danger btn-block">
                                            <i class="fas fa-trash"></i> {{ __('Clear') }}
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" id="complete-sale-btn" class="btn btn-success btn-block">
                                            <i class="fas fa-check"></i> {{ __('Complete Sale') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .quantity-controls button {
            width: 30px;
            height: 30px;
            padding: 0;
        }
    </style>

    <script>
        // State management (in-memory, no localStorage)
        let cart = [];
        let taxRate = {{ $tax_rate ?? 0 }};
        const currencySymbol = '{{ $currency_symbol ?? "$" }}';

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            initializeEventListeners();
            document.getElementById('tax-percentage').textContent = taxRate;
        });

        function initializeEventListeners() {
            // Product click - Add to cart
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const item = this.closest('.product-item');
                    addToCart({
                        id: item.dataset.productId,
                        name: item.dataset.productName,
                        price: parseFloat(item.dataset.productPrice),
                        quantity: 1
                    });
                });
            });

            // Product search
            document.getElementById('product-search').addEventListener('input', filterProducts);

            // Category filter
            document.getElementById('category-filter').addEventListener('change', filterProducts);

            // Discount calculation
            document.getElementById('discount-input').addEventListener('input', updateCartSummary);

            // Amount received calculation
            document.getElementById('amount-received').addEventListener('input', calculateChange);

            // Clear cart
            document.getElementById('clear-cart-btn').addEventListener('click', clearCart);

            // Complete sale
            document.getElementById('complete-sale-btn').addEventListener('click', completeSale);
        }

        function addToCart(product) {
            const existingItem = cart.find(item => item.id === product.id);

            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push(product);
            }

            renderCart();
            updateCartSummary();
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            renderCart();
            updateCartSummary();
        }

        function updateQuantity(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(productId);
                } else {
                    renderCart();
                    updateCartSummary();
                }
            }
        }

        function renderCart() {
            const container = document.getElementById('cart-items-container');

            if (cart.length === 0) {
                container.innerHTML = '<p class="text-center text-muted">{{ __('Cart is empty') }}</p>';
                return;
            }

            let html = '';
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                html += `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${item.name}</h6>
                                <small class="text-muted">${currencySymbol}${item.price.toFixed(2)} each</small>
                            </div>
                            <button class="btn btn-sm btn-danger" onclick="removeFromCart('${item.id}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="quantity-controls">
                                <button class="btn btn-sm btn-secondary" onclick="updateQuantity('${item.id}', -1)">-</button>
                                <span class="mx-2">${item.quantity}</span>
                                <button class="btn btn-sm btn-secondary" onclick="updateQuantity('${item.id}', 1)">+</button>
                            </div>
                            <strong>${currencySymbol}${itemTotal.toFixed(2)}</strong>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function updateCartSummary() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const taxAmount = (subtotal * taxRate) / 100;
            const discountPercent = parseFloat(document.getElementById('discount-input').value) || 0;
            const discountAmount = (subtotal * discountPercent) / 100;
            const total = subtotal + taxAmount - discountAmount;

            document.getElementById('subtotal').textContent = currencySymbol + subtotal.toFixed(2);
            document.getElementById('tax-amount').textContent = currencySymbol + taxAmount.toFixed(2);
            document.getElementById('discount-amount').textContent = currencySymbol + discountAmount.toFixed(2);
            document.getElementById('total-amount').textContent = currencySymbol + total.toFixed(2);

            calculateChange();
        }

        function calculateChange() {
            const total = parseFloat(document.getElementById('total-amount').textContent.replace(currencySymbol, ''));
            const received = parseFloat(document.getElementById('amount-received').value) || 0;
            const change = Math.max(0, received - total);

            document.getElementById('change-amount').textContent = currencySymbol + change.toFixed(2);
        }

        function filterProducts() {
            const searchTerm = document.getElementById('product-search').value.toLowerCase();
            const categoryId = document.getElementById('category-filter').value;

            document.querySelectorAll('.product-item').forEach(item => {
                const name = item.dataset.productName.toLowerCase();
                const category = item.dataset.categoryId;

                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !categoryId || category === categoryId;

                item.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
            });
        }

        function clearCart() {
            if (cart.length === 0 || !confirm('{{ __('Are you sure you want to clear the cart?') }}')) {
                return;
            }

            cart = [];
            document.getElementById('discount-input').value = '0';
            document.getElementById('amount-received').value = '';
            renderCart();
            updateCartSummary();
        }

        function completeSale() {
            if (cart.length === 0) {
                alert('{{ __('Cart is empty!') }}');
                return;
            }

            const total = parseFloat(document.getElementById('total-amount').textContent.replace(currencySymbol, ''));
            const received = parseFloat(document.getElementById('amount-received').value) || 0;

            if (received < total) {
                alert('{{ __('Insufficient payment amount!') }}');
                return;
            }

            // Prepare sale data
            const saleData = {
                customer_id: document.getElementById('customer-select').value || null,
                items: cart,
                subtotal: parseFloat(document.getElementById('subtotal').textContent.replace(currencySymbol, '')),
                tax: parseFloat(document.getElementById('tax-amount').textContent.replace(currencySymbol, '')),
                discount: parseFloat(document.getElementById('discount-amount').textContent.replace(currencySymbol,
                    '')),
                total: total,
                payment_method: document.getElementById('payment-method').value,
                amount_received: received,
                change: received - total,
                _token: '{{ csrf_token() }}'
            };

            // Submit to server
            fetch('{{ route('user.pos.complete-sale') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(saleData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('{{ __('Sale completed successfully!') }}');
                        clearCart();
                        // Optionally print receipt or redirect
                        if (data.receipt_url) {
                            window.open(data.receipt_url, '_blank');
                        }
                    } else {
                        alert('{{ __('Error completing sale: ') }}' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('{{ __('An error occurred while completing the sale') }}');
                });
        }
    </script>
@endsection
