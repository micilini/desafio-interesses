var inputTags = [];

var options = {
	url: "iDent/public/assets/interests.json",

	getValue: "name",

	list: {
	    maxNumberOfElements: 6,
		match: {
			enabled: true
		},
		onClickEvent: function() {
			addNewTag();
		}
	}
};

$('input[name=tags]').easyAutocomplete(options);

$(document).on("keyup", 'input[name=tags]', function (e) {
    if (e.keyCode == 188) {
	
	$(this).val(function(index, value){
    return value.substr(0, value.length - 1);
	});
	
    addNewTag();
	
    }
});

$('#tags_inserted').on('click','.btnTags', function(){
removeTagList($(this).attr("data"));
$(this).remove(); 
});

function removeTagList(tag){
var index = inputTags.indexOf(tag);
if (index !== -1) inputTags.splice(index, 1);
}

function selectInputValue(){
	return $('input[name=tags]').val();
}

function addNewTag(nameOfTag){

    var inputValue = selectInputValue();
	
	if($.inArray(inputValue, inputTags) > -1){
	$('input[name=tags]').val('');
	return;
	}
	
	$('#tags_inserted').css("display", "block");
	$('<div class="btn btn-info btnTags" style="width:auto; margin:5px;" data="'+ inputValue +'">' + inputValue + ' <i class="far fa-times-circle"></i></div>').appendTo('#tags_inserted');
	
	$('input[name=tags]').val('');
	
	inputTags.push(inputValue);
	
}

function arrayContains(needle, arrhaystack){
    return (arrhaystack.indexOf(needle) > -1);
}

$( "#buttonSend" ).click(function(e) {
e.preventDefault();

if(inputTags.length >= 3){

sendDataToDatabase();

}else{

swal({
  title: "Nenhum Interesse ?",
  text: "Você deve informar pelo menos 3 interesses para continuar. Você tambem pode pular esta etapa e preencher mais tarde.",
  icon: "warning",
  button: "Tudo bem",
});

}

});

function sendDataToDatabase(){

console.log(inputTags);

$.ajax({
        url: "home/inserttags",
        type: "post",
        data: {'interest' : JSON.stringify(inputTags)},
        success: function (response) {
           console.log(response);
		   
		   if(response == 1){
		   redirectToFinishPage();
		   }else{
		   errorMessage();
		   }
		   
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


});

}

function redirectToFinishPage(){

var url = 'home/finish';
var form = $('<form action="' + url + '" method="post">' +
  '<input type="text" name="data_json" value="' + inputTags.toString() + '" />' +
  '</form>');
$('body').append(form);
form.submit();

}

function errorMessage(){

swal({
  title: "Algo deu errado :(",
  text: "Isso não era para ter acontecido, a nossa equipe já foi notificada e resolveremos este problema o mais rapido possivel!",
  icon: "error",
  button: "Ok...",
});

}