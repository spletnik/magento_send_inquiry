$jinquiry = jQuery.noConflict();
$jinquiry(document).ready(function(){
    /*
    $jinquiry("#sendInquiry").bind("click", function(e){
        e.preventDefault();
        showSendInquiryPopUp($jinquiry("#sendInquiryForm").html()); 
    });
     */
    
    $jinquiry(".sendInquiry,#sendInquiry").bind("click", function(e){
        e.preventDefault();
        
        // dobi product name lang atribut attr               
        //var productName = $jinquiry('.product-name h1').html();
        var productName = $jinquiry(this).filter('.product-name').html();
        
        /*if ( $jinquiry('.product-name a').html() != ""){
          var productName = $jinquiry('.product-name h1').html();  
        } else {
          var productName = $jinquiry('.product-name a',$jinquiry(this).parent().parent()).html();
        }
        
        if(typeof(productName) == "undefined" || productName==null){
          productName = $jinquiry('.product-name a').html(); 
        }*/


        var currentUrl = $jinquiry(this).find('span span').attr('title');
        var product_id = $jinquiry(this).find('span span').attr('product_id');
        $jinquiry.ajax({
            url: currentUrl + "showForm",
            data: "productId="+product_id,
            success: function(data){
                data = $jinquiry.parseJSON(data);                                               
                showSendInquiryPopUp(data);
            }
        });
    });
    
    $jinquiry("#nyroModalContent input, #nyroModalContent textarea").live("click", function(event) {
        if($jinquiry(this).hasClass('error')){
            $jinquiry(this).removeClass('error');
        }
    });
    

    function showSendInquiryPopUp(data){
        $jinquiry.nyroModalManual({
            content:  data,
            width: 750,
            height: 550,
            endShowContent: sendInquiryPopUpShown
        });
        
        // Prevent posting data its window, make post request instead
        function sendInquiryPopUpShown() {
            $jinquiry('#nyroModalContent input[type="submit"]').bind("click", function(e){
            
                $jinquiry('.errors').empty();
            
                e.preventDefault();
                $jinquiry.post($jinquiry('#nyroModalContent form').attr('action'),              
                    $jinquiry('#nyroModalContent form').serialize(), 
                    function(data) {                        
                        data = $jinquiry.JSON.decode(data);                                             
                        if (data instanceof Array) {
                    
                            $jinquiry.each(data, function(index, value) { 
                                //$jinquiry('.''').append("<p>"+value+"</p>");
                                $jinquiry("#nyroModalContent #"+value).addClass(" error");                          
                            }); 
                            
                        } else {                        
                            // Do the same for new data which we got from post request
                            showSendInquiryPopUp(data);
                        }
                    });
            });
        }
    }
});
