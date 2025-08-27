const getId = localStorage.getItem('productId');

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
let singleItem = [];
for (let i = 0; products.length; i++) {
  if (products[i].id == getId) {
    console.log(products[i]);
    singleItem = products[i];
    console.log(singleItem);
    document.getElementById('product-img').src = singleItem.img;
    document.querySelector(".page-title").innerHTML = singleItem?.title;
    document.getElementById('pppp').innerText = singleItem.price;
    document.getElementById('product-desc').innerText = singleItem.title;


    console.log(singleItem);
  }
}
