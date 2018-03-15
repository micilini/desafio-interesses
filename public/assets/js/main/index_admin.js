
var inputTags = [];

var options = {
	url: function(phrase) {
		return "home/returnAllInterests/?phrase=" + phrase;
	},

	getValue: "name",

	list: {
	    maxNumberOfElements: 6,
		match: {
			enabled: true
		},
		onClickEvent: function() {
		}
	}
};

$('input[name=tags]').easyAutocomplete(options);

$( "#remap" ).click(function(e) {
  e.preventDefault();
  
  if(checkIfInputIsFilled()){
     remapTag($("#tag_interest").attr("data-name"), $('input[name=tags]').val(), $("#tag_interest").attr("data-id"));
  }
  
});

function checkIfInputIsFilled(){

var inputValue = $('input[name=tags]').val();

if(inputValue){
return true;
}else{
$('input[name=tags]').val($("#tag_interest").attr("data-name"));
return false;
}

}

function remapTag(name_tag, input_tag, id_tag){

$.ajax({
        url: "admin/remaptag",
        type: "post",
        data: {'name_tag' : name_tag, 'input_tag' : input_tag, 'id_tag' : id_tag, 'checkbox' : getCheckBoxValueIfExists()},
        success: function (response) {
           if(response == 1){
		      location.reload();
		   }else{
		      errorMessage();
		   }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


});

}

function getCheckBoxValueIfExists(){

if($('#multiple_remap').length){

    if ($('#multiple_remap').is(":checked")){
         return true;
    }

}

return false;

}

function errorMessage(){

swal({
  title: "Algo deu errado :(",
  text: "Isso não era para ter acontecido, a nossa equipe já foi notificada e resolveremos este problema o mais rapido possivel!",
  icon: "error",
  button: "Ok...",
});

}