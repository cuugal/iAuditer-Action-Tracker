<?php defined('BASEPATH') OR exit('No direct script access allowed');?>



<div class="row" >
    <div class="col-md-12 col-lg-12">
        <h1>New Manual Action Entry</h1>
            <br/>
        <br/>
		NOTE: An email notification will be sent to the person accountable for this Area of Accountability.

        <?php if (isset($_SESSION['ma_message'])) : ?>
            <div class="alert alert-success"><?=$_SESSION['ma_message'];?>
            </div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?= $this->form_builder->open_form(array('action' => ''));
        echo $this->form_builder->build_form_horizontal(
            array(

                array(
                    'id' => 'area_of_accountability',
                    'type'=>'dropdown',
                    'options' => $aoa,
                    'class'=>"chosen-select",
                    'req'=>true

                ),
                array(
                    'id' => 'inspection_type',
                    'type'=>'dropdown',
                    'options' => $types,
                    'class'=>"chosen-select",
                    'req'=>true

                ),
                /*
                array(
                    'id' => 'inspector_name',
                ),
*/
                array(
                    'id' => 'created_at',
                    'label' => 'Date',
                    'data-provide'=>'datepicker',
                    'data-date-format'=>"dd/mm/yyyy",
                    'req'=>true
                ),
                array(
                    'id' => 'location',
                    'label'=>'Specific Location',
                    'req'=>true
                ),
                array(
                    'id' => 'inspector_name',
                    'value'=>$inspector_name,
                    'readonly'=>true,
                    'req'=>true
                ),
                array(
                    'id' => 'items',
                    'type'=>'hidden',

                ),

            )
        );

        ?>
        <div class="panel-body with-table" id="action_items">
            <div class="form-group">
                <div class="col-sm-3">
                    <div style="float:left">
                        <a data-toggle="modal" data-target="#myModal" id="newBtn" class="btn btn-primary">Add Action Item</a>
                        <a style="margin-left:5px" id="removeBtn" class="btn btn-primary">Remove</a>
                    </div>

                </div>
                <h4 style="text-align:left; float:left; padding-left:10px">Action Items</h4>
            </div>
            <table id="items" class="action_register table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Issue</th>
                    <th>Inspection Notes</th>
                    <th>Hazard Type</th>
                    <th>Proposed Action</th>

                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <input type="submit" name="submit" class="btn btn-primary" value="Save"/>
        <?php
        echo $this->form_builder->close_form();?>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Action Item</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="" id="actionform" class="form-horizontal col-sm-12 validate">
                    <div class="form-group required">
                        <label class="control-label col-sm-2">Issue</label>
                        <div class="col-sm-9">
                            <input type="text" data-validate="required" required
                                   class="form-control" name="issue" id="issue" value="">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-sm-2">Inspection Notes</label>
                        <div class="col-sm-9">
                            <input type="text" data-validate="required" required
                                   class="form-control" name="notes" id="notes">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-sm-2">Hazard Type</label>
                        <div class="col-sm-9">


                            <select data-validate="required" required class="chosen-select form-control"
                                    name="type_of_hazard" id="type_of_hazard">
                                <?php foreach($hazards as $key=>$value):?>
                                    <option value="<?=$key;?>"><?=$value;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="control-label col-sm-2">Proposed Action</label>
                        <div class="col-sm-9">
                            <input type="text" data-validate="required" required
                                   class="form-control " name="proposed_action" id="proposed_action">
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="button" id="newRow" class="btn btn-primary" style="float:none">Ok</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</div>

<?php if(isset($_SESSION['ma_message'])):?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#action_items").hide();
    })
</script>
<?php endif;?>

<script type="text/javascript">
    function htmlToJson(table) {
        // If exists the cols: "edit" and "del" to remove from JSON just pass values = 1 to edit and del params

        var data = [];
        var colsLength = $(table.find('thead tr')[0]).find('th').length;
        var rowsLength = $(table.find('tbody tr')).length;
         // first row needs to be headers
        var headers = [];
        for (var i=1; i<colsLength; i++) {
            head = $(table.find('thead tr')[0]).find('th').eq(i).text();
            head=head.replace(/ /g,"_");
            head = head.toLowerCase();
            if(head == 'inspection_notes'){
                head = 'notes';
            }
            if(head == 'hazard_type'){
                head = 'type_of_hazard';
            }
            headers[i] = head;
        }

        // go through cells
        for (var i=0; i<rowsLength; i++) {
            var tableRow = $(table.find('tbody tr')[i]);
            var rowData = {};
            for (var j=1; j<colsLength; j++) {
                rowData[ headers[j] ] = tableRow.find('td').eq(j).text();
            }
            data.push(rowData);
        }

        return JSON.stringify(data)
    }


    $(".chosen-select").chosen();
    $('input[name=submit]').after('<a style="margin-left:10px" class="btn btn-primary" href="<?php echo site_url('Dashboard'); ?>">Cancel</a>');

    $('#myModal').on('shown.bs.modal', function () {
        $('.chosen-select', this).chosen('destroy').chosen();
    });

    $("#newRow").click(function(){
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });
        var form = $( "#actionform" );
        form.validate();


        if(!form.valid()){
            return false;
        }
        html = '<tr>';
        html += '<td><input type="checkbox" name="select"></td>'
        html += '<td>' + $("#issue").val() + '</td>';
        html += '<td>' + $("#notes").val() + '</td>';
        html += '<td>' + $("#type_of_hazard").val() + '</td>';
        html += '<td>' + $("#proposed_action").val() + '</td>';
        //html += '<td>' + $("#reviewed_action").val() + '</td>';
        html += '</tr>';

        $('#items tbody').append(html);


        tbl = htmlToJson($('#items'));
        $("[name='items']").val(tbl);
        $("#myModal").modal('hide');

        $("#issue").val('');
        $("#notes").val('');
        $("#type_of_hazard").val('');
        $("#proposed_action").val('');
        //$("#reviewed_action").val('');
    });

    $("#removeBtn").on("click", function () {
        $('table tr').has('input[name="select"]:checked').remove();
        tbl = htmlToJson($('#items'));
        $("[name='items']").val(tbl);
    })
</script>

<style type="text/css">
    input.error{
        border: 1px solid red;
    }
    label.error{
        color:red;
    }
</style>