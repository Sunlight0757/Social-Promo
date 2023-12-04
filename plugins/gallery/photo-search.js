'use strict';   

let searchBtn = document.querySelector('#search-btn');
let imgResultsUnsplash = document.querySelector('#img-results-unsplash');
let imgResultsPixabay = document.querySelector('#img-results-pixabay');
let imgResultsPexels = document.querySelector('#img-results-pexels');
let numResults = document.querySelector('#num-results');
let searchBar = document.querySelector('#search');
let pagination = document.querySelector('#pagination')

let category = '';
let totalResults;
let totalPages = 0;

let page = 1;

let resW = "1080"
let resH = ""

function nextPage() {
    if (searchBar.value) {
        page++
        searchPhotos();
    }
}

function prevPage() {
    if (page > 1 && searchBar.value) {
        page--
        searchPhotos();
    }
}

async function searchPhotos() {
    let query = searchBar.value;
    category = query;

    let urlUnsplash = "https://api.unsplash.com/search/photos?page=" + page + "&per_page=30&query=" + query +
        "&client_id=BfA9_xPqsWwU2Nfvb5yeh_WJdxRf4_HQKDI44eM-Xwg&orientation=landscape";

    let urlPexels = "https://api.pexels.com/v1/search?query=" + query + "&page=" + page + "&per_page=30";

    let urlPixabay = "https://pixabay.com/api/?key=17535032-a5253e7c9ad5342bf8abd845d&q=" + query +
        "&image_type=photo&per_page=30&page=" + page;

    imgResultsUnsplash.innerHTML = '';
    imgResultsPixabay.innerHTML = '';
    imgResultsPexels.innerHTML = '';

    removeH5('#unsplash h5')
    removeH5('#pixabay h5')
    removeH5('#pexels h5')

    let unsplashResults = 0;
    let unsplashPages = 0;
    let pixabayResults = 0;
    let pexelResults = 0;


    /* --- Unsplash API --- */
    fetch(urlUnsplash)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            console.log(data);
            unsplashResults = data.total;

            unsplashPages = data.total_pages;

            if (data.results != 0) {
                imgResultsUnsplash.insertAdjacentHTML("beforebegin", '<h5>Unsplash Results</h5>')
                data.results.forEach(imageJson => {
                    // image = `<img src = "${imageJson.urls.small}" class="img-thumbnail" onclick="downloadPhoto(this)">`
                    let image = `<img src = "${imageJson.urls.small}" class="img-thumbnail" 
                              onclick="downloadPhoto('${imageJson.urls.full}', '${imageJson.id}')">`
                    imgResultsUnsplash.insertAdjacentHTML("beforeend", image)
                })
            } else {
                removeH5('#unsplash h5')
            }
        })


    /* --- Pixabay API --- */
    fetch(urlPixabay).then((response) => {
        return response.json()
    })
        .then((data) => {
            console.log(data);

            pixabayResults = data.total;

            if (data.hits != 0) {
                imgResultsPixabay.insertAdjacentHTML("beforebegin", '<h5>Pixabay Results</h5>')
                data.hits.forEach(hit => {
                    let image = `<img src = "${hit.previewURL}" class="img-thumbnail" 
                        onclick="downloadPhoto('${hit.webformatURL}', '${hit.id}')">`
                    imgResultsPixabay.insertAdjacentHTML("beforeend", image)
                })
            } else {
                removeH5('#pixabay h5')
            }
        })

        pagination.innerHTML =
        `<ul class="pagination text-center mx-auto">
			<li class="page-item"><a class="page-link" onclick="prevPage()">Previous</a></li>
			<li class="page-item"><a class="page-link" onclick="nextPage()">Next</a></li>
	 	</ul>`

         
    /* --- Pexels API --- */
    fetch(urlPexels, {
        method: 'GET',
        headers: {
            authorization: "563492ad6f91700001000001be28925d2473490cba62628e8328d6fc"
        }
    })
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            console.log(data);

            pexelResults = data.total_results;

            if (data.photos != 0) {
                imgResultsPexels.insertAdjacentHTML("beforebegin", '<h5>Pexels Results</h5>')
                data.photos.forEach(photo => {
                    let image = `<img src = "${photo.src.medium}" class="img-thumbnail" 
			            onclick="downloadPhoto('${photo.src.original}', '${photo.id}')">`
                    imgResultsPexels.insertAdjacentHTML("beforeend", image)
                });
            } else {
                removeH5('#pexels h5')
            }
        })
        .then(() => {
            if (unsplashResults | pexelResults) {

                totalResults = (isNaN(unsplashResults) ? 0 : +unsplashResults) +
                    (isNaN(pexelResults) ? 0 : +pexelResults) +
                    (isNaN(pixabayResults) ? 0 : +pixabayResults);

                numResults.textContent = 'Images found: ' + totalResults + ' 😀 | Page '
                    + page + ' of ' + Math.max(unsplashPages, Math.ceil(pixabayResults/30));
            } else {
                numResults.textContent = 'No images on that 😢'
                unsplashPages = 0;
            }
        });
}

function downloadPhoto(url, id) {
    let imgPath = url + "?&w=1080&fit=crop";
    console.log(imgPath);

    let filename = category + '-' + id + '-1080.jpg';
    saveAs(imgPath, filename);
}

function pressEnter() {
    if (event.key === 'Enter')
        searchPhotos();
}

function removeH5(querySelector){
    document.querySelector(querySelector) ? document.querySelector(querySelector).remove() : false;
}