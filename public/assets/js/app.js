let cardLayout = document.getElementById('cards');
let cardData = [];




function getPosts() {
  fetch('https://jsonplaceholder.typicode.com/posts')
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      cardData = data;
      console.log(cardData);
      let html = '';
      cardData.forEach((e) => {
        html += `   <div class="card col-md-4  py-4">
                    <a href="post.html" class="text-decoration-none text-dark" onClick="post(${e.id})">
                    <h5>${e.title}</h5>
                    <img src="${e.img}">
                    <div class="row pt-5">
                        <div class="col">
                            <h6>${e.category}</h6>
                            <p>${e.item}</p>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn  px-4 card-btn">see more <i class="fa-solid fa-arrow-right" onClick="post(${e.id})"></i></button>
                        </div>
                    
                    </div>
                </div>`;
        cardLayout.innerHTML = html;
      });
    });
}


// getPosts();

