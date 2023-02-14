var accion = '';
$(function() {
    let fecha = new Date();
    $('#fechaOd').text(new moment().format('DD/MM/YYYY'));
    
    $('.info-pt').fadeOut(0);
    $('#radio').change(function () {
        accion = $("input[name='accion']:checked").val();
        if(accion=='borrar'){
            $("#radio_seccion").fadeIn(200);
        }else{
            $("#radio_seccion").fadeOut(200);
        }
    });
});

function imprimir(){
    $( '.row1' ).css( "min-height", "710px" );
    $('.act-rad').fadeOut(0);
    $('.info-pt').fadeIn(0);
    window.print();
    $('.info-pt').fadeOut(0);
    $('.act-rad').fadeIn(0);
    $( '.row1' ).css( "min-height", "510px" );
    $('#radio').change();

}

// Funcion para dibujar las lineas de cada diente
function dibuja_contorno(context, inicio_x, inicio_y, med, separacion_x, separacion_y){
    var ctx = context;
    // Definiendo puntos de dibujo
    cua = med/4;
    ter = cua*3;
    /* 1ra zona */
    if(ctx){
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(inicio_x,inicio_y);
        ctx.lineTo(med+inicio_x,inicio_y);
        ctx.lineTo(ter+inicio_x,cua+inicio_y);
        ctx.lineTo(cua+inicio_x,cua+inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
    /* 2da zona */
    if(ctx){
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(ter+inicio_x,cua+inicio_y);
        ctx.lineTo(med+inicio_x,inicio_y);
        ctx.lineTo(med+inicio_x,med+inicio_y);
        ctx.lineTo(ter+inicio_x,ter+inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
    /* 3ra zona */
    if(ctx){
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(cua+inicio_x,ter+inicio_y);
        ctx.lineTo(ter+inicio_x,ter+inicio_y);
        ctx.lineTo(med+inicio_x,med+inicio_y);
        ctx.lineTo(inicio_x,med+inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
    /* 4ta zona */
    if(ctx){
        ctx.strokeStyle = color_line;
        ctx.beginPath();
        ctx.moveTo(inicio_x,inicio_y);
        ctx.lineTo(cua+inicio_x,cua+inicio_y);
        ctx.lineTo(cua+inicio_x,ter+inicio_y);
        ctx.lineTo(inicio_x,med+inicio_y);
        ctx.closePath();
        ctx.stroke();
    }
}
// Funcion para pintar una region del diente
function dibuja_seccion(contexto, num_diente, seccion, color_pas){
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    cua = med/4;
    ter = cua*3;
    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente<16){
        inicio_y = 20;
    }else if(num_diente > 16 && num_diente < 33){
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }else if(num_diente > 33 && num_diente < 49){
        num_diente = num_diente - 32;
        inicio_y = med + 220;
        
    }else if(num_diente > 49){
        num_diente = num_diente - 48;
        inicio_y = med + 340;
        
    }
    inicio_x = (num_diente*med) + (separacion_x*num_diente) + separacion_x;
    /* 1ra zona */
    if (seccion==1){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x,inicio_y);
            ctx.lineTo(med+inicio_x,inicio_y);
            ctx.lineTo(ter+inicio_x,cua+inicio_y);
            ctx.lineTo(cua+inicio_x,cua+inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 2da zona */
    if (seccion==2){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(ter+inicio_x,cua+inicio_y);
            ctx.lineTo(med+inicio_x,inicio_y);
            ctx.lineTo(med+inicio_x,med+inicio_y);
            ctx.lineTo(ter+inicio_x,ter+inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 3ra zona */
    if (seccion==3){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua+inicio_x,ter+inicio_y);
            ctx.lineTo(ter+inicio_x,ter+inicio_y);
            ctx.lineTo(med+inicio_x,med+inicio_y);
            ctx.lineTo(inicio_x,med+inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 4ta zona */
    if (seccion==4){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x,inicio_y);
            ctx.lineTo(cua+inicio_x,cua+inicio_y);
            ctx.lineTo(cua+inicio_x,ter+inicio_y);
            ctx.lineTo(inicio_x,med+inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
    /* 5ta zona(medio) */
    if (seccion==5){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua+inicio_x,cua+inicio_y);
            ctx.lineTo(ter+inicio_x,cua+inicio_y);
            ctx.lineTo(ter+inicio_x,ter+inicio_y);
            ctx.lineTo(cua+inicio_x,ter+inicio_y);
            ctx.closePath();
            ctx.fill();
            ctx.strokeStyle = 'black';
            ctx.stroke();
        }
    }
}
//
// Funcion para sombrear
function marcar_seccion(contexto, num_diente, seccion, color_pas){
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    cua = med/4;
    ter = cua*3;
    num_diente = num_diente - 1;
    color_line = color_pas;

    /**
     * En las siguientes lineas se hace la distinción a partir del número de diente se toma el inicio de la figura
     * obteniendo su punto inicial en Y
     **/

    if (num_diente<16){
        inicio_y = 20;
    }else if(num_diente > 16 && num_diente < 33){
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }else if(num_diente > 33 && num_diente < 49){
        num_diente = num_diente - 32;
        inicio_y = med + 220;
        
    }else if(num_diente > 49){
        num_diente = num_diente - 48;
        inicio_y = med + 340;
        
    }
    
    inicio_x = (num_diente*med) + (separacion_x*num_diente) + separacion_x;
    
    /* 1ra zona */
    if (seccion==1){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x,inicio_y);
            ctx.lineTo(med+inicio_x,inicio_y);
            ctx.lineTo(ter+inicio_x,cua+inicio_y);
            ctx.lineTo(cua+inicio_x,cua+inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 2da zona */
    if (seccion==2){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(ter+inicio_x,cua+inicio_y);
            ctx.lineTo(med+inicio_x,inicio_y);
            ctx.lineTo(med+inicio_x,med+inicio_y);
            ctx.lineTo(ter+inicio_x,ter+inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 3ra zona */
    if (seccion==3){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua+inicio_x,ter+inicio_y);
            ctx.lineTo(ter+inicio_x,ter+inicio_y);
            ctx.lineTo(med+inicio_x,med+inicio_y);
            ctx.lineTo(inicio_x,med+inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 4ta zona */
    if (seccion==4){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(inicio_x,inicio_y);
            ctx.lineTo(cua+inicio_x,cua+inicio_y);
            ctx.lineTo(cua+inicio_x,ter+inicio_y);
            ctx.lineTo(inicio_x,med+inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
    /* 5ta zona(medio) */
    if (seccion==5){
        if(ctx){
            ctx.fillStyle = color_line;
            ctx.beginPath();
            ctx.moveTo(cua+inicio_x,cua+inicio_y);
            ctx.lineTo(ter+inicio_x,cua+inicio_y);
            ctx.lineTo(ter+inicio_x,ter+inicio_y);
            ctx.lineTo(cua+inicio_x,ter+inicio_y);
            ctx.closePath();
            //ctx.fill();
            ctx.strokeStyle = 'yellow';
            ctx.stroke();
        }
    }
}
// Funcion para sombrear diente completo
function marcar_diente(contexto, num_diente, color_pas){
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente<16){
        inicio_y = 20;
    }else if(num_diente > 16 && num_diente < 33){
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }else if(num_diente > 33 && num_diente < 49){
        num_diente = num_diente - 32;
        inicio_y = med + 220;
        
    }else if(num_diente > 49){
        num_diente = num_diente - 48;
        inicio_y = med + 340;
        
    }
    //alert(num_diente);
    inicio_x = (num_diente*med) + (separacion_x*num_diente) + separacion_x;

    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.moveTo(inicio_x,inicio_y);
    ctx.lineTo(inicio_x+40,inicio_y);
    ctx.lineTo(inicio_x+40,inicio_y+40);
    ctx.lineTo(inicio_x,inicio_y+40);
    ctx.closePath();
    ctx.strokeStyle = color_line;
    ctx.stroke();
}
// Funcion para sombrear diente completo
function marcar_extraccion(contexto, num_diente, color_pas){
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente = num_diente - 1;
    color_line = color_pas;
    if (num_diente<16){
        inicio_y = 20;
    }else if(num_diente > 16 && num_diente < 33){
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }else if(num_diente > 33 && num_diente < 49){
        num_diente = num_diente - 32;
        inicio_y = med + 220;
        
    }else if(num_diente > 49){
        num_diente = num_diente - 48;
        inicio_y = med + 340;
        
    }
    //alert(num_diente);
    inicio_x = (num_diente*med) + (separacion_x*num_diente) + separacion_x;

    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.lineWidth = 3;
    ctx.moveTo(inicio_x,inicio_y);
    ctx.lineTo(inicio_x+40,inicio_y+40);
    ctx.moveTo(inicio_x+40,inicio_y);
    ctx.lineTo(inicio_x,inicio_y+40);
    ctx.stroke();
    ctx.lineWidth = 1;
}
// Funcion para marcar puente
function marcar_puente(contexto, dient_1, dient_2, color_pas){
    var ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente1 = dient_1 - 1;
    num_diente2 = dient_2 - 1;
    color_line = color_pas;
    if (num_diente1<16){
        inicio_y = 80;
    }else if(num_diente1 > 16 && num_diente1 < 33){
        num_diente1 = num_diente1 - 16;
        num_diente2 = num_diente2 - 16;
        inicio_y = med + 160;
    }else if(num_diente1 > 32 && num_diente1 < 49){
        num_diente1 = num_diente1 - 32;
        num_diente2 = num_diente2 - 32;
        inicio_y = med + 280;
    }
    //alert(num_diente);
    inicio_x = (num_diente1*med) + (separacion_x*num_diente1) + separacion_x + (med/2);
    fin_x = (num_diente2*med) + (separacion_x*num_diente2) + separacion_x + (med/2);
    ctx.fillStyle = color_line;
    ctx.beginPath();
    ctx.lineWidth = 4;
    ctx.moveTo(inicio_x,inicio_y);
    ctx.lineTo(fin_x,inicio_y);
    ctx.stroke();
    ctx.lineWidth = 1;
}
// Funcion para marcar puente
function borrar_diente(contexto, num_diente){
    ctx = contexto;
    // Definiendo puntos de dibujo
    med = medida;
    num_diente = num_diente - 1;
    if (num_diente<16){
        inicio_y = 20;
    }else if(num_diente > 16 && num_diente < 33){
        num_diente = num_diente - 16;
        inicio_y = med + 100;
    }else if(num_diente > 33 && num_diente < 49){
        num_diente = num_diente - 32;
        inicio_y = med + 220;
        
    }else if(num_diente > 49){
        num_diente = num_diente - 48;
        inicio_y = med + 340;
        
    }
    //alert(num_diente);
    inicio_x = (num_diente*med) + (separacion_x*num_diente) + separacion_x;
    ctx.clearRect(inicio_x, inicio_y, med, med);
}

// Valores iniciales
var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');
//
var layer2 = document.getElementById("myCanvas2");
var ctx2 = layer2.getContext("2d");
//
var layer3 = document.getElementById("myCanvas3");
var ctx3 = layer3.getContext("2d");
//
var layer4 = document.getElementById("myCanvas4");
var ctx4 = layer4.getContext("2d");
//
var color_line = 'black';
var medida = 40;
var separacion_x = 10;
var separacion_y = 10;
var iniciar_x = 0;
var iniciar_y = 20;
//Dientes para el puente
var diente1=0;
var diente2=0;
// 1 - 16 dientes
for (x=0; x<16; x++){
    iniciar_x =  (x*medida) + (separacion_x*x) + separacion_x;
    dibuja_contorno(context, iniciar_x, iniciar_y, medida, separacion_x, 10);
    /* Numero de diente */
    context.font = '10pt Calibri';
    context.textAlign = 'center';
    context.fillStyle = 'blue';
    context.fillText(/*x+1*/tags['data'][x].text, iniciar_x+(medida/2), (iniciar_y/2)+5);
}
// 17 - 32 dientes
iniciar_x = 0;
iniciar_y = medida + 100;
for (x=0; x<16; x++){
    if(x>2 && x<13){
        iniciar_x =  (x*medida) + (separacion_x*x) + separacion_x;
        dibuja_contorno(context, iniciar_x, iniciar_y, medida, separacion_x, 10);
        /* Numero de diente */
        context.font = '10pt Calibri';
        context.textAlign = 'center';
        context.fillStyle = 'blue';
        context.fillText(/*x+1*/tags['data'][x+16].text, iniciar_x+(medida/2), (iniciar_y-10)+5);
    }
}
// 33 - 48 dientes
iniciar_x = 0;
iniciar_y = medida + 220;
for (x=0; x<16; x++){
    if(x>2 && x<13){
        iniciar_x =  (x*medida) + (separacion_x*x) + separacion_x;
        dibuja_contorno(context, iniciar_x, iniciar_y, medida, separacion_x, 10);
        /* Numero de diente */
        context.font = '10pt Calibri';
        context.textAlign = 'center';
        context.fillStyle = 'blue';
        context.fillText(/*x+1*/tags['data'][x+32].text, iniciar_x+(medida/2), (iniciar_y-10)+5);
    }
}
// 49 - 64 dientes
iniciar_x = 0;
iniciar_y = medida + 340;
for (x=0; x<16; x++){
    iniciar_x =  (x*medida) + (separacion_x*x) + separacion_x;
    dibuja_contorno(context, iniciar_x, iniciar_y, medida, separacion_x, 10);
    /* Numero de diente */
    context.font = '10pt Calibri';
    context.textAlign = 'center';
    context.fillStyle = 'blue';
    context.fillText(/*x+1*/tags['data'][x+48].text, iniciar_x+(medida/2), (iniciar_y-10)+5);
}
window.onload = function(){
    localStorage.clear();
    click();
}
function click(){
    //Añadimos un addEventListener al canvas para reconocer el click
    layer4.addEventListener("click",
    //Una vez se haya clickado se activará la siguiente función
    getPosition
    ,false);
    layer4.addEventListener("mousemove",Marcar,false);
}
//canvas.addEventListener("mousedown", getPosition, false);

function getPosition(event){
    var x = event.x;
    var y = event.y;
    //alert(y);
    //alert(x);
    var canvas = document.getElementById("myCanvas");
    var div_can = document.getElementById("canvasesdiv");
    x -= div_can.offsetLeft;
    y -= div_can.offsetTop;
    //alert(div_can.offsetTop);
    var div=0;
    var color='';
    accion='';
    seleccion = $("input[name='accion']:checked").val();
    if (seleccion == 'fractura'){
        color = 'red';
        accion = 'seccion';
    }
    else if(seleccion=='restauracion'){
        color = 'blue';
        accion = 'seccion';
    }
    else if(seleccion=='extraccion'){
        color = 'black';
        accion = 'marcar';
    }
    else if(seleccion=='puente'){
        accion = 'puente';
    }
    else if(seleccion=='borrar'){
        accion = 'borrar';
    }
    //alert(y);
    diente = 0;
    seccion = 0;
    /**
     * Aqui hace la distincion de que diente esta observando tomando como base que 
     * la primera linea de dientes empieza en 1 y la segunda de 17 con la posiciones 
     * en y entre 20 y 60 para la primer fila y 140 y 180 para la segunda fila 
     * 
     * Para la segunda y tercer fila se restringen las posciones solo para los 10 dientes
     * existentes
     **/
    // 1er fila
    if (y>=20 && y<=60){
        //alert(x);
        if (x>=10 && x<=50){
            diente = 1;
        }
        else if (x>=60 && x<=800){
            div =  parseInt(x/50,10);
            ini = (div*40) + (10*div) + 10;
            fin = ini + 40;
            if (x>=ini && x<=fin){
                diente=div+1;
            }
        }
    }
    // 2nda fila 
    else if(y>=140 && y<=180){
        if (x>=150 && x<= 650){
            if (x>=10 && x<=50){
                diente = 17;
            }
            else if (x>=60 && x<=800){
                div =  parseInt(x/50,10);
                ini = (div*40) + (10*div) + 10;
                fin = ini + 40;
                if (x>=ini && x<=fin){
                    diente=div+17;
                }
            }
        }
    }
    // 3er fila
    else if(y>=260 && y<=300){
        if (x>=150 && x<= 650){
            if (x>=10 && x<=50){
                diente = 33;
            }
            else if (x>=60 && x<=800){
                div =  parseInt(x/50,10);
                ini = (div*40) + (10*div) + 10;
                fin = ini + 40;
                if (x>=ini && x<=fin){
                    diente=div+33;
                }
            }
        }
    }
    // 4ta fila
    else if(y>=380 && y<=420){
        if (x>=10 && x<=50){
            diente = 49;
        }
        else if (x>=60 && x<=800){
            div =  parseInt(x/50,10);
            ini = (div*40) + (10*div) + 10;
            fin = ini + 40;
            if (x>=ini && x<=fin){
                diente=div+49;
                //alert(diente);
            }
        }
    }
    if (diente){
        //alert(diente);
        if(accion == 'seccion'){
            x = x-((div*40) + (10*div) + 10);
            /**
             * En esta parte obtiene una altura relativa independientemente de la sección de modo
             * que incluso estando en una cuarta linea la sección 1 estará hasta un máximo de 10 
             **/
            y = y-20;
            if (diente>16 && diente < 33){
                y = y-120;
            }
            if (diente>33 && diente <49){
                y = y-240;
            }
            if (diente>49 && diente <65){
                y = y-360;
            }
            /**
             * Las "Secciones" sin las 5 opciones clickeables existentes por diente
             * van en el sentido de las agujas del reloj
             */
            if (y>0 && y<10 && x>y && y<40-x){
                seccion = 1;
            }else if (x>30 && x<40 && y<x && 40-x<y){
                seccion = 2;
            }else if (y>30 && y<40 && x<y && x>40-y){
                seccion = 3;
            }else if (x>0 && x<10 && y>x && x<40-y){
                seccion = 4;
            }else if (x>10 && x<30 && y>10 && y<30){
                seccion = 5;
            }
            //alert(seccion);
        }else if(accion == 'marcar'){
            cod=diente+'-0-'+'3';
            if(cod && !localStorage.getItem(cod)){
                new_array=[diente, 0, 3, Date.now(), 0];
                guardar = new_array.toLocaleString();
                localStorage.setItem(cod, guardar);
                marcar_extraccion(ctx2, diente, 'black')
            }else{
                //alert("Ya fue marcado");
                let Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000
                  });

                  Toast.fire({
                    icon: 'error',
                    title: 'La secci&oacute;n ya fue marcada!'
                  });
            }
        }else if(accion == 'puente'){
            if (diente1==0){
                marcar_diente(ctx4, diente, 'red');
                diente1=diente;
            }else if(diente2==0){
                diente2=diente;
                menor=0;
                mayor=0;
                if(diente1>diente2){
                    mayor=diente1;
                    menor=diente2;
                }else{
                    mayor=diente2;
                    menor=diente1
                }
                diente1=menor;
                diente2=mayor;
                if ((diente1<17 && diente2<17 && diente1!=diente2) || (diente1>17 && diente2>17 && diente1!=diente2)){
                    marcar_diente(ctx4, diente, 'red');
                    ctx4.clearRect(0, 0, 810, 70);
                    ctx4.clearRect(0, 135, 810, 70);
                    cod=diente1+'-0-4-'+diente2;
                    if(cod && !localStorage.getItem(cod)){
                        new_array=[diente1, 0, 4, Date.now(), diente2];
                        guardar = new_array.toLocaleString();
                        localStorage.setItem(cod, guardar);
                    }else{
                        //alert("Ya fue marcado");
                        let Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1000
                        });

                        Toast.fire({
                            icon: 'error',
                            title: 'La secci&oacute;n ya fue marcada!'
                        });
                    }
                    marcar_puente(ctx4, diente1, diente2, 'red');
                }else{
                    ctx4.clearRect(0, 0, 810, 70);
                    ctx4.clearRect(0, 135, 810, 70);
                }
                
                diente1=0;
                diente2=0;
            }
        }else if(accion == 'borrar'){
            borrar_diente(ctx2, diente);
            //cargar el ultimo pintado
            seccion_chk = $("input[name='seccion']:checked").val();
            if (seccion_chk=='seccion'){
                x = x-((div*40) + (10*div) + 10);
                y = y-20;
                if (diente>16 && diente < 33){
                    y = y-120;
                }
                if (diente>33 && diente <49){
                    y = y-240;
                }
                if (diente>49 && diente <65){
                    y = y-360;
                }
                seccion_b=ubica_seccion(x,y);
                if (seccion_b){
                    ultimo = '';
                    key_cod='';
                    for(var i=0; i < localStorage.length; i++){
                        var key_name = localStorage.key(i);
                        item = localStorage.getItem(key_name);
                        item = item.split(',');
                        diente_comp = parseInt(item[0],10);
                        seccion_comp = parseInt(item[1],10);
                        accion_comp = parseInt(item[2],10);
                        if(diente_comp==diente && seccion_b==seccion_comp && (accion_comp==1 || accion_comp==2)){
                            if(ultimo==''){
                                ultimo=item;
                                key_cod=key_name;
                            }
                            else{
                                fecha_ult = parseInt(item[3],10);
                                if(ultimo[3]<fecha_ult){
                                    ultimo=item;
                                    key_cod=key_name;
                                }
                            }
                        }
                    }
                    if(key_cod!=''){
                        //console.log(key_cod);
                        localStorage.removeItem(key_cod);
                    }
                }
            }else if(seccion_chk=='diente'){
                ultimo = '';
                key_cod='';
                for(var i=0; i < localStorage.length; i++){
                    var key_name = localStorage.key(i);
                    item = localStorage.getItem(key_name);
                    item = item.split(',');
                    diente_comp = parseInt(item[0],10);
                    accion_comp = parseInt(item[2],10);
                    if(diente_comp==diente && accion_comp==3 ){
                        if(ultimo==''){
                            ultimo=item;
                            key_cod=key_name;
                        }
                        else{
                            fecha_ult = parseInt(item[3],10);
                            if(ultimo[3]<fecha_ult){
                                ultimo=item;
                                key_cod=key_name;
                            }
                        }
                    }
                }
                if(key_cod!=''){
                    //console.log(key_cod);
                    localStorage.removeItem(key_cod);
                }
            }
            //alert('a');
            pinta_datos();
        }
    }
    //alert(diente);
    if (seccion && color!=''){
        //alert(color);
        
        //alert(seccion);
        //[numero_diente, seccion, accion, fecha, diente2]
        if (color=='red'){
            cod=diente+'-'+seccion+'-'+'1';
            accion_g = 1;
        }else if (color=='blue'){
            cod=diente+'-'+seccion+'-'+'2';
            accion_g = 2;
        };
        if(cod && !localStorage.getItem(cod)){
            new_array=[diente, seccion, accion_g, Date.now(), 0];
            guardar = new_array.toLocaleString();
            localStorage.setItem(cod, guardar);
            dibuja_seccion(ctx2, diente, seccion, color);
        }
        else{
            //alert("Ya fue marcado");
            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000
              });

              Toast.fire({
                icon: 'error',
                title: 'La secci&oacute;n ya fue marcada!'
              });
        }
        
    }
    if ( 'borrar' == $("input[name='accion']:checked").val()){
        //alert("x-> "+x+" y-> "+y);
        //ctx4.clearRect(0, 0, 810, 510);
        
        if (x>=30 && x<=780 && ((y>78 && y<82) || (y>198 && y<202))){
            //alert(x);
            div =  parseInt(x/50,10);
            //alert(div);
            ultimo = '';
            key_cod='';
            for(var i=0; i < localStorage.length; i++){
                var key_name = localStorage.key(i);
                item = localStorage.getItem(key_name);
                item = item.split(',');
                diente1_comp = parseInt(item[0],10);
                diente2_comp = parseInt(item[4],10);
                accion_comp = parseInt(item[2],10);
                if(accion_comp==4){
                    if (diente1_comp>16){
                        diente1_comp = diente1_comp - 17;
                        diente2_comp = diente2_comp - 17;
                    }else{
                        diente1_comp = diente1_comp - 1;
                        diente2_comp = diente2_comp - 1;
                    }
                    inicio_x = (diente1_comp*40) + (10*diente1_comp) + 10 + 20;
                    fin_X = (diente2_comp*40) + (10*diente2_comp) + 10 + 20;
                    if (x>=inicio_x && x<=fin_x){
                        if(ultimo==''){
                            ultimo=item;
                            key_cod=key_name;
                        }
                        else{
                            fecha_ult = parseInt(item[3],10);
                            if(ultimo[3]<fecha_ult){
                                ultimo=item;
                                key_cod=key_name;
                            }
                        }
                    }
                    
                }
            }
            if(key_cod!=''){
                //console.log(key_cod);
                if(parseInt(ultimo[0],10)<16){
                    seccion_p=1;
                    ctx4.clearRect(0, 0, 810, 130);
                }
                else{
                    ctx4.clearRect(0, 130, 810, 150);
                    seccion_p=2;
                }
                localStorage.removeItem(key_cod);
                pinta_puentes(seccion_p);
            }
        }
        
    }
    
}

function Marcar(event){
    var x = event.x;
    var y = event.y;
    var canvas2 = document.getElementById("myCanvas2");
    var div_can = document.getElementById("canvasesdiv");
    x -= div_can.offsetLeft;
    y -= div_can.offsetTop;
    diente=0;
    seccion=0;
    var div=0;
    
    /**
     * Evalua la linea de dientes para a partir de ahi marcar el contorno amarillo.
     * 
     * Para las filas 3 y 4 se ponen las restricciones solo para los dientes existentes
     * por eso se limita el área mayor o acaso igual a 150 y menor o acaso igual a 650.
     **/ 
    // 1er fila
    if (y>=20 && y<=60){
        //alert(x);
        if (x>=10 && x<=50){
            diente = 1;
            //alert("1");
        }
        else if (x>=60 && x<=800){
            div =  parseInt(x/50,10);
            ini = (div*40) + (10*div) + 10;
            fin = ini + 40;
            if (x>=ini && x<=fin){
                diente=div+1;
            }
        }
    }
    // 2da fila
    else if(y>=140 && y<=180){
        if (x>=150 && x<= 650){
            if (x>=10 && x<=50){
                diente = 17;
            }
            else if (x>=60 && x<=800){
                div =  parseInt(x/50,10);
                ini = (div*40) + (10*div) + 10;
                fin = ini + 40;
                if (x>=ini && x<=fin){
                    diente=div+17;
                }
            }
        }
    }
    // 3er fila
    else if(y>=260 && y<=300){
        if (x>=150 && x<= 650){
            if (x>=10 && x<=50){
                diente = 33;
            }
            else if (x>=60 && x<=800){
                div =  parseInt(x/50,10);
                ini = (div*40) + (10*div) + 10;
                fin = ini + 40;
                if (x>=ini && x<=fin){
                    diente=div+33;
                }
            }
        }
    }
    // 4ta fila
    else if(y>=380 && y<=420){
        if (x>=10 && x<=50){
            diente = 49;
        }
        else if (x>=60 && x<=800){
            div =  parseInt(x/50,10);
            ini = (div*40) + (10*div) + 10;
            fin = ini + 40;
            if (x>=ini && x<=fin){
                diente=div+49;
            }
        }
    }
    //alert('Altura: '+y);
    //alert('diente: '+diente);
    if (diente) {
        accion = $("input[name='accion']:checked").val();
        var seleccion = '';
        if (accion == 'fractura'){
            seleccion = 'seccion';
        }
        else if(accion=='restauracion'){
            seleccion = 'seccion';
        }
        else if(accion=='extraccion'){
            seleccion = 'diente';
        }
        else if(accion=='puente'){
            seleccion = 'diente';
        }
        else if(accion=='borrar'){
            seccion_chk = $("input[name='seccion']:checked").val();
            if (seccion_chk=='diente'){
                seleccion = 'diente';
            }
            else{
                seleccion = 'seccion';
            }
        }
        if (seleccion=='seccion'){
            x = x-((div*40) + (10*div) + 10);
            y = y-20;
            if (diente>16 && diente <33){
                y = y-120;
            }
            if (diente>33 && diente <49){
                y = y-240;
            }
            if (diente>49 && diente <65){
                y = y-360;
            }
            //alert(y);
            /*if (y>=x && y<=39){}*/
            // Ubicar la seccion clickeada
            if (y>0 && y<10 && x>y && y<40-x){
                seccion = 1;
            }else if (x>30 && x<40 && y<x && 40-x<y){
                seccion = 2;
            }else if (y>30 && y<40 && x<y && x>40-y){
                seccion = 3;
            }else if (x>0 && x<10 && y>x && x<40-y){
                seccion = 4;
            }else if (x>10 && x<30 && y>10 && y<30){
                seccion = 5;
            }
            //alert(seccion)
            //Comprobacion de si esta en una seccion
            if (seccion){
                //alert(seccion);
                color = 'yellow';
                ctx3.clearRect(0, 0, 810, 510);
                marcar_seccion(ctx3, diente, seccion, color);
                //alert(seccion);
            }else{
                //ctx2.fillStyle = "white";
                //ctx2.fillRect(0, 0, 810, 510);
                ctx3.clearRect(0, 0, 810, 510);
            }
        }
        else if(seleccion=='diente'){
            ctx3.clearRect(0, 0, 810, 510);
            marcar_diente(ctx3, diente, 'yellow');
        }
    }else{
        ctx3.clearRect(0, 0, 810, 510);
    }
    
    //dibuja_contorno(canvas, inicio_x, inicio_y, med, separacion_x, separacion_y)
}
function pinta_datos(){
    array_local = [];
    for(var i=0; i < localStorage.length; i++){
        var key_name = localStorage.key(i);
        array_local[i]=localStorage.getItem(key_name).split(',');
    }
    //console.log(array_local);
    array_local.sort(function(a,b){
        return a[3] > b[3]; // orden ascendente por las fechas;
    });
    //console.log(array_local);
    for(var i=0; i < array_local.length; i++){
        item = array_local[i];
        if(parseInt(item[0],10)==diente){
            acc = parseInt(item[2],10);
            //console.log(acc);
            if (acc==1){
                color='red';
                dibuja_seccion(ctx2, item[0], item[1], color);
            }else if (acc==2){
                color='blue';
                dibuja_seccion(ctx2, item[0], item[1], color);
            }else if (acc==3){
                marcar_extraccion(ctx2, item[0], 'black');
            }
        }
    }
}
function pinta_puentes(seccion_p){
    array_local = [];
    for(var i=0; i < localStorage.length; i++){
        var key_name = localStorage.key(i);
        array_local[i]=localStorage.getItem(key_name).split(',');
    }
    //console.log(array_local);
    array_local.sort(function(a,b){
        return a[3] > b[3]; // orden ascendente por las fechas;
    });
    //console.log(array_local);
    for(var i=0; i < array_local.length; i++){
        item = array_local[i];
        acc = parseInt(item[2],10);
        //console.log(acc);
        if (acc==4){
            color_pas = 'red';
            console.log(item);
            if (seccion_p==1){
                if(parseInt(item[0],10)<17){
                    marcar_puente(ctx4, item[0], item[8], color_pas);
                }
            }else{
                if(parseInt(item[0],10)>16){
                    marcar_puente(ctx4, item[0], item[8], color_pas);
                }
            }
        }
        
    }
}
function ubica_seccion(X,Y){
    y=Y;
    x=X;
    devolver_seccion=0;
    if (y>0 && y<10 && x>y && y<40-x){
        devolver_seccion = 1;
    }else if (x>30 && x<40 && y<x && 40-x<y){
        devolver_seccion = 2;
    }else if (y>30 && y<40 && x<y && x>40-y){
        devolver_seccion = 3;
    }else if (x>0 && x<10 && y>x && x<40-y){
        devolver_seccion = 4;
    }else if (x>10 && x<30 && y>10 && y<30){
        devolver_seccion = 5;
    }
    return devolver_seccion;
}