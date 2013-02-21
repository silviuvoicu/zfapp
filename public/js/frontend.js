//var idCdUrl;
function displayBooks(response){
    //alert(response);
    response = JSON.parse(response);
    //alert(response.cds[0]);
    //idCdUrl = response.idCdUrl;
    // alert(idCdUrl);
    $("#cdsResponse").html('');
    var cdsHtml = '<div id="cds">';
    // alert(cdsHtml);
    var index;
    for(var i in response.cds){
        //alert(response.cds[i].interpret);id="'+response.cds[i].id+'"
        if(response.idCdUrl== response.cds[i].id){
            
            index = i;
        }
        cdsHtml += '<h3><a href="#">'+response.cds[i].titel+'</a></h3><div>'
        //  +'<span id="'+response.cds[i].id+'" style="display: none;">' + response.cds[i].id+' </span> ' 
        + 'perform by '+response.cds[i].interpret+'<br />'
        + 'in the year '+  response.cds[i].jahr +'<br />'+
        response.editLink[i]+' '+ response.deleteLink[i]+'<br />'+
        response.details[i]+'<br />'+
        response.paginator2[i]+
        '</div>';
    //    if (response.idCdUrl == response.cds[i].id){
    //   $("div .paginatorCDSComents"+response.cds[i].id,$("#cds")[0]).live("click",function (event){
    //       alert(event.target);
    //       getBooks(event.target);
    //     //  return false;
    //      event.preventDefault();
    //   }); 
    //    }  
    }
    cdsHtml += '</div>';
    // alert(cdsHtml);
    $("#cdsResponse").append(cdsHtml);
    
    //alert(response.idCdUrl);
    //var index;
    if (index != null) {
        // alert(index)      ;
        //       index =  ($("h3").each(function(){
        //         if( $(this).hasClass('ui-state-active')){
        //              var elem = $(this);
        //              return elem;
        //         }  
        //          }));
        //          alert(index.index());
           
        $("#cds").accordion( {
            "active": parseInt(index)
        });
    //$("#cdsResponse > #cds").accordion({"active":"none", "collapsible" : "true"});

    }else{
        $("#cdsResponse > #cds").accordion({
            "active":"none", 
            "collapsible" : "true"
        });
    }
	
	
    $("#currentPage").html(response.currentPage);
    $("#currentPage2"+response.cds[i].id).html(response.currentPage2[i]);
    updatePageLinks(response.pages,response.url);
    
//return idCdUrl;
     
//  exit;
	
}


function updatePageLinks(pages,url){
    if (pages.previous){
        $("div.paginatorCDS >span#page"+pages.first).hide();
        if (($("div.paginatorCDS >a#beginning").length ==0)){
            $("div.paginatorCDS >span#page"+pages.first).before('<a id="beginning" href="'+url+pages.first+'">'+'Beginning'+'</a> ');
        }else{
            $("div.paginatorCDS >a#beginning").show();
        }
        if (($("div.paginatorCDS >a#previous").length ==0)){
            $("div.paginatorCDS >a#beginning").after(' <span id="beforepreviousline"> | </span> <a id="previous" href="'+url+pages.previous+'">'+'&lt; Previous'+'</a>  <span id="afterpreviousline"> | </span>');
        }
        else{
             $("div.paginatorCDS >span#beforepreviousline").show();
            $("div.paginatorCDS >a#previous").attr('href',url+pages.previous);
            $("div.paginatorCDS >a#previous").show();
           
            $("div.paginatorCDS >span#afterpreviousline").show();
        }
    }else{
        //$("div.paginatorCDS >a"+pages.first).before('<span id ="beginning">  <b>Beginning</b>  </span> ');
        $("div.paginatorCDS >a#beginning").hide();
        $("div.paginatorCDS >a#previous").hide();
        $("div.paginatorCDS >span#beforepreviousline").hide();
        $("div.paginatorCDS >span#afterpreviousline").hide();
        
    }
    for(page in pages.pagesInRange){
     
        if( page != pages.current ){
            // console.log('page '+ page);
            if(($("div.paginatorCDS > span#page"+page).length!= 0)){
                $("div.paginatorCDS > span#page"+page).hide();
                $("div.paginatorCDS > span#currentlinepage"+page).hide();
                
               
                if ( $("div.paginatorCDS > a#page"+page).length != 0){
                    $("div.paginatorCDS > a#page"+page).show();
                    $("div.paginatorCDS > span#currentlinepage"+page).hide();
                    if( $("div.paginatorCDS > span#notcurrentlinepage"+page).length !=0){
                        $("div.paginatorCDS > span#notcurrentlinepage"+page).show();
                    }else{
                        $("div.paginatorCDS > a#page"+page).after('<span id="notcurrentlinepage'+page+'"> | </span> ');
                    } 
                
                    
                }else{
                    $("div.paginatorCDS > span#page"+page).after('<a id="page'+page+'" href="'+url+page+'">'+page+'</a>');
                    $("div.paginatorCDS > span#currentlinepage"+page).hide();
                    if( $("div.paginatorCDS > span#notcurrentlinepage"+page).length !=0){
                        $("div.paginatorCDS > span#notcurrentlinepage"+page).show();
                    }else{ 
                      //  if (page != pages.last)
                        $("div.paginatorCDS > a#page"+page).after('<span id="notcurrentlinepage'+page+'"> | </span> ');
                    }
                }  
            }else{
                $("div.paginatorCDS > a#page"+page).show();
                $("div.paginatorCDS > span#page"+page).hide();
                $("div.paginatorCDS > span#currentlinepage"+page).hide();
                 if( $("div.paginatorCDS > span#notcurrentlinepage"+page).length !=0){
                        $("div.paginatorCDS > span#notcurrentlinepage"+page).show();
                    }else{
                        $("div.paginatorCDS > a#page"+page).after('<span id="notcurrentlinepage'+page+'"> | </span> ');
                    }
              
            }
       
           
        }else{
            // console.log('current page '+pages.current);
            $("div.paginatorCDS > a#page"+page).hide();
            $("div.paginatorCDS > span#notcurrentlinepage"+page).hide();
            if (page != pages.last){
            if( $("div.paginatorCDS > span#currentlinepage"+page).length !=0){
                        $("div.paginatorCDS > span#currentlinepage"+page).show();
                    }else{
                        $("div.paginatorCDS > a#page"+page).after('<span id="currentlinepage'+page+'"> | </span> ');
                    }
             }       
            if(($("div.paginatorCDS > span#page"+page).length== 0)){
                $("div.paginatorCDS > a#page"+page).after('<span id="page'+page+'"><b>'+page+'</b></span>');
                $("div.paginatorCDS > span#notcurrentlinepage"+page).hide();
                 if (page != pages.last){
                if( $("div.paginatorCDS > span#currentlinepage"+page).length !=0){
                        $("div.paginatorCDS > span#currentlinepage"+page).show();
                    }else{
                        $("div.paginatorCDS > a#page"+page).after('<span id="currentlinepage'+page+'"> | </span> ');
                    }
                 }
            }else{
                $("div.paginatorCDS > span#page"+page).show();
                $("div.paginatorCDS > span#notcurrentlinepage"+page).hide();
                 if (page != pages.last){
                if( $("div.paginatorCDS > span#currentlinepage"+page).length !=0){
                        $("div.paginatorCDS > span#currentlinepage"+page).show();
                    }else{
                        $("div.paginatorCDS > a#page"+page).after('<span id="notcurrentlinepage'+page+'"> | </span> ');
                    }
                 }
            }
        }
    }
    if (pages.next){
       
        if (($("div.paginatorCDS >a#end").length ==0)){
           // console.log("div.paginatorCDS >a#page"+pages.next);
            if (pages.next == pages.last){
            $("div.paginatorCDS >span#notcurrentlinepage"+pages.next).after(' <a id="end" href="'+url+pages.last+'">'+'End'+'</a>');
            }else{
            $("div.paginatorCDS >span#notcurrentlinepage"+pages.last).after(' <a id="end" href="'+url+pages.last+'">'+'End'+'</a>');
            }
        }else{
            $("div.paginatorCDS >a#end").show();
        }
        if (($("div.paginatorCDS >a#next").length ==0)){
            $("a#end").before('<a id="next" href="'+url+pages.next+'">'+'Next &gt;'+'</a> <span id="nextafterline"> | </span>  ');
        }
        else{
            $("div.paginatorCDS >a#next").attr('href',url+pages.next);
            
            
            $("div.paginatorCDS >a#next").show();
            $("div.paginatorCDS >span#nextafterline").show();
        }
      
    }else{
        $("#end").show();
        $("div.paginatorCDS >a#end").hide();
        $("div.paginatorCDS >a#next").hide();
        $("div.paginatorCDS >span#nextafterline").hide()
        
    }

}

function getBooks(link){
    // alert($(link).attr(id));
    var url = link;
    //link;
    // alert(url);
        
    //$(link).attr('href');
    //window.location.path;
    //alert (url);
    //$(link).attr('href');
    //window.location.path.name + '/page/' + $(this).attr('page');
    // alert(url);
        
    $.post(url,
    {
        "format" : "json"
    },
    function(data,textStatus){
        displayBooks(data);
    }, 'html');
    return false;
}
function getLink(){
    // var link = null;
    $('a').each(
        function(){
            // alert($(this).attr('href'));
            //link = ;
         
            $(this).live('click',function(){

                return $(this);
                  
            }

            )
        }
        )

        
    
//return link;
}
function getInputValues(elem)
{
    var data ={};
    data[$(elem).attr('name')] = $(elem).val();
        
    return data;
}
function doValidation( formName,id )
{
    var form = $('form');
    var url = '';
    if  (form.attr('name')== formName){
        url = form.attr('action')+"/format/json";
    }
    //'/auth/login/format/json';
    //var idElem ='' ;
    //console.log(url);
    var data = {};
    $("input, textarea").each(function()
    {
        // console.log($(this).attr('id')==id);
        //       if($(this).attr('id')==id) {
        //        data[$(this).attr('name')] = $(this).val();
        //       }else if (id == null ){
        data[$(this).attr('name')] = $(this).val();
    //  }
    });
    //var elem = "#"+id;
    // console.log(idElem);
    // data = getInputValues(elem);
    //  data[$(this).attr('name')] = $(this).val();
    // console.log(data);
    $.post(url,data,
        function(response){
            //response = JSON.parse(response);
            //  console.log(response);
            for (i in response){
                //   console.log('id '+id);
                if (id == null) {
                    console.log("form login event");
                    if(response[i]){
                 
                        console.log(i);
                        console.log(response[i]);
                        
                        // $("#login").find('.errors').remove();   
                        $("#errors-"+i).parent().find("#errors-"+i).remove();
                        $("#"+i).parent().append(getErrorHtml(response[i], i));
                         
                        $("#login").parent().find('#errors-'+'recaptcha').remove();
                    }
                    if(response['errorMessage']!=null){
                        $("#login").parent().find('#errors-'+'errorMessage').remove();
                        $("#login").before(getErrorHtml(response['errorMessage'], 'errorMessage'))
                    //  return false;
                    //  Recaptcha.reload();
                    }else{
                        $("#login").parent().find('#errors-'+'errorMessage').remove();
                    }
                    if(response['notActivated']!=null){
                        $("#login").parent().find('#errors-'+'notActivated').remove();
                        $("#login").before(getErrorHtml(response['notActivated'], 'notActivated'))
                    //  return false;
                    //  Recaptcha.reload();
                    }else{
                        $("#login").parent().find('#errors-'+'notActivated').remove();
                    }
                    if (i == 'recaptcha'){
                        if(response['recaptcha']!=null){
                            $("#login").parent().find('#errors-'+'recaptcha').remove();
                            $("#login").before(getErrorHtml(response['recaptcha'], 'recaptcha'))
                        // Recaptcha.reload();
                        //  return false;
                        }else{
                    //     Recaptcha.reload();
                    }
                       
                    }
                    if (response['ok']) {
              
                        $('form').submit();
            
                    }
                }else{
                    console.log("on blur event");
                    console.log(response);
                    if(response[id]){
                        console.log("#errors-"+id);
                        // $("#login").find('.errors').remove();   
                        $("#errors-"+id).parent().find("#errors-"+id).remove();
                        $("#"+id).parent().append(getErrorHtml(response[id], id));
                    //return false;
                    }else{
                        $("#errors-"+id).parent().find("#errors-"+id).remove();  
                    }
                    //                    if(response['recaptcha']!=null){
                    //                        $("#login").parent().find('#errors-'+'recaptcha').remove();
                    //                        $("#login").before(getErrorHtml(response['recaptcha'], 'recaptcha'))
                    //                    //  Recaptcha.reload();
                    //                    //  return false;
                    //                    }else{
                    //                        $("#login").parent().find('#errors-'+'recaptcha').remove();
                    //                    }
                   
                    if(response['errorMessage']!=null){
                        console.log(response['errorMessage']);
                        $("#login").parent().find('#errors-'+'errorMessage').remove();
                        $("#login").before(getErrorHtml(response['errorMessage'], 'errorMessage'))
                    //  return false;
                    }else{
                        $("#login").parent().find('#errors-'+'errorMessage').remove();
                    }
                    if(response['notActivated']!=null){
                        console.log(response['notActivated']);
                        $("#login").parent().find('#errors-'+'notActivated').remove();
                        $("#login").before(getErrorHtml(response['notActivated'], 'notActivated'))
                    //  return false;
                    }else{
                        $("#login").parent().find('#errors-'+'notActivated').remove();
                    }
                }
                continue;
    
            }
            
           
    
        
       
    
        }, 'json');
    
    

}
function getErrorHtml(formErrors , id)
{
    var o = '<ul id="errors-'+id+'" class="errors">';
    if(null !== formErrors && 'object' == typeof(formErrors)){
        for(errorKey in formErrors)
        {
            o += '<li>' + formErrors[errorKey] + '</li>';
        }
    }else{
        o += '<li>' + formErrors + '</li>';
    }
    o += '</ul>';
    return o;
}


$(document).ready(function() {
   
    
    $("input, textarea").blur(function(e)
 
    {
           
            //  var formElementId = $(this).parent().prev().find('label').attr('for');
            var formElementId = $(this).attr('id');
            var formName = $('form').attr('name');
            console.log(formElementId);
            //alert(formElementId);           
            doValidation(formName,formElementId);
     
      
        });
 

    $('form').click(function(e){
        //  var formElementId = $(this).parent().prev().find('label').attr('for');
        //        //alert(formElementId);
        //if(doValidation()){$('form').submit()}
        var formName = $('form').attr('name');        
        var elem   = e.target;
        //        alert(elem.type);
        //         alert(elem.name);
        if ((elem.name == 'login') || (elem.type == 'submit')){
            // alert(elem.name);
            doValidation(formName);
            e.preventDefault();
        }else{
            return false;
        }           
    
    });

    $("div .paginatorCDSComents").live("click",function (event){
        var elem =event.target;
        if(typeof(elem.type)=='string'){
            getBooks(event.target);
        }
        event.preventDefault();
    }); 
    $("div.paginatorCDS").click(function (event){
        var elem =event.target;
       // alert(elem);
        if(typeof(elem.type)=='string'){
            getBooks(event.target);
        }
        event.preventDefault();
    });
   
})

 