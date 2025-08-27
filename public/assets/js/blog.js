let blogLayout = document.getElementById('blog-Layout');

let post = [
  {
    id: 1,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    body: 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining',
  },
  {
    id: 2,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    body: 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining ',
  },
  {
    id: 3,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    body: 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining ',
  },
  {
    id: 4,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    body: 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining ',
  },
  {
    id: 5,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    body: 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining ',
  },
  {
    id: 6,
    img: '/images/product-img.png',
    title: 'Glamorous looooooooooook ...',
    body: 'text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining',
  },
];

function setPost(id) {
  localStorage.setItem('postId', id);
}

function getPosts() {
  let html = '';
  post.forEach((e) => {
    html += ` <div class="col-md-4 my-5 blog-card">
                    <a href="post.html" class="text-decoration-none text-dark" onClick="setPost(${e.id})">
                    <div class="blog-img-wrapper">
                        <img src="${e.img}" width="100%">
                    </div>
                    <div class="my-3">
                        <h5 class="blog-title">${e.title}</h5>
                        <p class="my-4">${e.body}</p>
                        <a href="post.html" class="readmore-btn d-flex text-decoration-none" onClick="setPost(${e.id})">
                            <h6>Read More <i class="fa-solid fa-angles-right"></i> </h6>
                        </a>
                    </div>
                </div>`;
    blogLayout.innerHTML = html;
  });
}
getPosts();
