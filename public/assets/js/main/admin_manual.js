$(document).ready(function() {

    $('#example').DataTable( {
  "columnDefs": [
    { "width": "32%", "targets": 0 }
  ], 
  "language":
  {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
  }
   });

} );

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

$('input[name=tags]').keypress(function (e) {
   
   var data_id = $(this).attr('data-id');
   var data_type = $(this).attr('data-type');
   var input_tag = $(this).val();

   if(e.which ==13){
   console.log('data_id: ' + data_id + ' data_type: ' + data_type + ' input_tag: ' + input_tag);
    autoRemapTag(data_id, data_type, input_tag);
   }
   
});

function autoRemapTag(data_id, data_type, input_tag){

$.ajax({
        url: "remaptagmanual",
        type: "post",
        data: {'data_id' : data_id, 'data_type' : data_type, 'input_tag' : input_tag},
        success: function (response) {
           if(response == 1){
		   
		   $('input[data-id='+ data_id +']').val('');
		   $('td[data-id='+ data_id + data_type +']').html(input_tag);
		   
		   }else{
		   errorMessage();
		   }
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


});

}

function errorMessage(){

swal({
  title: "Algo deu errado :(",
  text: "Isso não era para ter acontecido, a nossa equipe já foi notificada e resolveremos este problema o mais rapido possivel!",
  icon: "error",
  button: "Ok...",
});

}