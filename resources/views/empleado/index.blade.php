@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">


                <button class="btn btn-primary btn-check" >Enviar</button>

                <hr>

            <div class="table-responsive">
                <table id="consulta" class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Oficina</th>
                            <th>Edad</th>
                            <th>Fecha de Inicio</th>
                            <th>Salario</th>
                        </tr>
                    </thead>
                </table>
            </div>


      
        </div>
    </div>
</div>


<!-- Modal Registro-->
<form id="registro" autocomplete="off">
    
<div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <button class="btn btn-primary">Registrar</button>

        @csrf

        <hr>

        <div class="table-responsive">
               <table id="consulta_check" class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Oficina</th>
                            <th>Edad</th>
                            <th>Fecha de Inicio</th>
                            <th>Salario</th>
                        </tr>
                    </thead>
                </table>
            </div>

      </div>

    </div>
  </div>
</div>




</form>



<script>
    function loadData(){


        $(document).ready(function(){

            //Datatable

        table =  $('#consulta').DataTable({

                destroy:true,
                bAutoWidth: false,
                ajax:{

                    url:'{{ route('empleado.index') }}',
                    type:'GET'

                },
                columns:[

                    {data:'id'},
                    {data:'nombre'},
                    {data:'puesto'},
                    {data:'oficina'},
                    {data:'edad'},
                    {data:'fecha_inicio'},
                    {data:'salario'}

                ],
                columnDefs:[

                    {

                    targets:0,
                    checkboxes:{
                     seletRow:true
                    }

                    }


                ],
                select:{

                style:'multi'
                },
                order:[[1,'asc']]







            });


        //CheckBox
        $(document).on('click','.btn-check',function(e){

           var rows = table.column(0).checkboxes.selected();

           var data = [];//Array que contendrá los elementos

            $.each(rows,function(index,rowId){

            //Agregar elementos al Array
            data.push(rowId);

            });

            if(data.length>0){


                $.ajax({

                    url:'{{ route('empleado.envio') }}',
                    type:'POST',
                    data:{'_token':'{{ csrf_token() }}','items':data},
                    dataType:'JSON',
                    beforeSend:function(){


                        Swal.fire({

                            title:'Cargando',
                            text :'Espere un Momento...',
                            showConfirmButton:false


                        });


                    },
                    success:function(result){


                        Swal.fire({

                            title:'Buen Trabajo',
                            text :'Información Cargada',
                            icon :'success',
                            timer : 1000,
                            showConfirmButton:false


                        });

                         // data = JSON.parse(result);

                        $('#consulta_check').DataTable( {
                        data: result,
                        destroy:true,
                        bAutoWidth: false,
                        columns: [

                                {data:'id'},
                                {data:'nombre'},
                                {data:'puesto'},
                                {data:'oficina'},
                                {data:'edad'},
                                {data:'fecha_inicio'},
                                {data:null,render:function(data){


                                    return ` 
                                    <input type="hidden" name="id[]" value="${data.id}" />
                                    <input type="number" step="any" name="salario[]"  value="${data.salario}" required />


                                    `;


                                }}

                        ]

                        } );


                        $('.modal-title').html('Registro de Datos');
                        $('#modal-registro').modal('show');

                    }



                });



            }else{


                Swal.fire({

                    title:'Lista Vacia',
                    text :'No ha seleccionado ningún elemento',
                    icon :'warning',
                    timer:2000,
                    showConfirmButton:false


                });


            }








        });




        });


    }


    loadData();


    //Registro
    $(document).on('submit','#registro',function(e){

        parametros = $(this).serialize();


        $.ajax({


                    url:'{{ route('empleado.registro') }}',
                    type:'POST',
                    data:parametros,
                    dataType:'JSON',
                    beforeSend:function(){


                        Swal.fire({

                            title:'Cargando',
                            text :'Espere un Momento...',
                            showConfirmButton:false


                        });


                    },
                    success:function(data){

                        if(data.icon=='success'){


                            setInterval(function(){

                                location.reload();


                            },3000);


                        }


                         Swal.fire({

                            title:data.title,
                            text :data.text,
                            icon :data.icon,
                            timer : 3000,
                            showConfirmButton:false


                        });



                    }




        });



        e.preventDefault();
    });


</script>


@endsection
