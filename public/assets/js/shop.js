let productLayout = document.getElementById('product-Layout');

let products = [
  {
    id: 1,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 2,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 3,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 4,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 5,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 6,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 7,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 8,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 9,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 10,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 11,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 12,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 13,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 14,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 15,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
  {
    id: 16,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    price: '₦3,000',
  },
];

function product(id) {
  localStorage.setItem('productId', id);
}

function getProducts() {
  let html = '';
  products.forEach((e) => {
    html += ` <div class="products-card p-3">
                    <a href="singleProduct.html" class="text-decoration-none text-dark" onClick="product(${e.id})">
                    <img src="${e.img}">
                    <div class="py-3">
                        <h6 class="product-title">${e.title}</h6>
                        <p class="product-price">${e.price}</p>
                    </div>
                </div>`;
    productLayout.innerHTML = html;
  });
}
getProducts();
