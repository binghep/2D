$(document).ready(function(){
 
    $("#btnSave2").click(function() { 
        var now=new Date();
        var strDateTime = [[ now.getFullYear(), AddZero(now.getMonth() + 1),AddZero(now.getDate())].join("_"), [AddZero(now.getHours()), AddZero(now.getMinutes()), AddZero(now.getSeconds())].join(":"), now.getHours() >= 12 ? "PM" : "AM"].join(" ");
        // var n=strDateTime.replace(/\W/g,'_');
        var n=strDateTime;
        html2canvas($("#exlucde_menu_html"), {
            onrendered: function(canvas) {
                theCanvas = canvas;
                // document.body.appendChild(canvas);
                canvas.toBlob(function(blob) {
          saveAs(blob, n+".png"); 
        });
            }
        });
    });
})

function AddZero(num) {
  return (num >= 0 && num < 10) ? "0" + num : num + "";
}


