// $(document).ready(function() {
//     console.log('coucou hovercarouselJS');
//     $('.product-thumbnail').hover(function() {
//         $(this).css({
//             opacity: '0.33', 
//             transition: 'opacity 0.3s', 
//         });
//     }, function() {
//         $(this).css({
//             opacity: 'initial', 
//             transition: 'initial', 
//         });
//     })
// });

// var Ets_ImageHover = {
//     inArray: function (item, items) {
//         var length = items.length;
//         for(var i = 0; i < length; i++) {
//             if(items[i] == item) return true;
//         }
//         return false;
//     },
//     ets_run_v17: function(){
//         if($('article.product-miniature').length >0){
//             var temps = [], ids = '', item = 0;
//             $('article.product-miniature').each(function(){
//                 item = parseInt($(this).data('id-product'));
//                 if(item > 0 && !Ets_ImageHover.inArray(item, temps))
//                     temps.push(item);
//             });
//             for(var i = 0; i < temps.length; i++)
//                 (i != temps.length - 1)? ids += temps[i] + ',' : ids += temps[i];
//             if(ids !=''){
//                 $.ajax({
//                     url : baseAjax,
//                     data : 'ids=' + ids,
//                     type : 'get',
//                     dataType: 'json',
//                     success : function(json){
//                         if(json){                            
//                             $.each(json,function(i,image){
//                                 if($('.product-miniature[data-id-product="'+i+'"] a.product-thumbnail img').length > 0){
//                                     $('.product-miniature[data-id-product="'+i+'"] a.product-thumbnail img').after(image);
//                                 }
//                             });
//                         }
//                     }
//                 });
//             }
//         }
//     }
// }

$(document).ready(function(){
    console.log('coucou');
    // $('.carousel').carousel({
    //     interval: 2000
    //   })

})