//funcion ajax
//completado es una funcion de callback que se ejecutara cuando los datos esten de vuelta
function ajax(url, metodo, datos = {}, completado) {
    //creamos el objeto xmlhttprequest
    let XHR = new XMLHttpRequest();

    //preparamos la respuesta
    XHR.onreadystatechange = function (evento) {
        if (XHR.readyState == 4 && XHR.status == 200) {
            //recogemos la respuesta
            completado(XHR.responseText);
        }
    }

    let cadenaDatos = "";
    for (let indice in datos) {
        cadenaDatos += indice + "=" + datos[indice] + "&";
    }

    if (metodo.toUpperCase() == "GET") {
        XHR.open(metodo, url + "?" + cadenaDatos);
        XHR.send();
    } else {
        XHR.open(metodo, url);
        XHR.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); //modificamos la cabecera para que admita los datos como si de un formulario se tratase
        XHR.send(cadenaDatos);
    }
}