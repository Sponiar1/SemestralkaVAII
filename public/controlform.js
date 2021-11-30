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
