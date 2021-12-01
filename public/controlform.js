function validateForm() {
    let x = document.forms["regForm"]["username"].value;
    if(x.length < 3) {
        alert("Krátke užívateľské meno");
        return false;
    }
    let y = document.forms["regForm"]["password"].value;
    let number = /\d/;
    if(y.length < 6) {
        alert("Krátke heslo");
        return false;
    }
    if(!number.test(y)) {
        alert("Heslo musí obsahovať aspoň jednu číslicu");
        return false;
    }
}
let slideIndex = 0;

function ukazPrvySlide() {
    let prvySlide = document.getElementsByClassName("sliders");
    setTimeout(() => {
        prvySlide[0].style.display = "block";
    }, 10);
}
ukazPrvySlide();

function plusSlides(n) {
    if(slideIndex+n === 3) {
        slideIndex = 0;
        showSlides(slideIndex);
    }else if(slideIndex+n === -1) {
        slideIndex = 2;
        showSlides(slideIndex);
    } else {
        showSlides(slideIndex += n);
    }
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("sliders");
    let dots = document.getElementsByClassName("dot");
    console.log(n);
    if (n > slides.length) {
        slideIndex = 0;
    }

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace("active", "");
    }
    if(slides[slideIndex]) {
        slides[slideIndex].style.display = "block";
        dots[slideIndex].className += " active";
    }
}
function showmodal(n) {
    let modal = document.getElementById("myModal");


    let img = document.getElementById("myImg" + n);
    let modalImg = document.getElementById("img01");
    let captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = img.alt;

    let span = document.getElementsByClassName("close")[0];

    span.onclick = function () {
        modal.style.display = "none";
    }
}