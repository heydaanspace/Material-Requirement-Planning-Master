<section class="section">
  <!-- Notification Session -->
  <div class="msg" style="display:none;">
    <?= @$this->session->flashdata('msg'); ?>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="col-4 text-left">
              <h4>Detail Pesanan Pembelian</h4>
            </div>
            <div class="col-8 text-right">
              <a href=""><i class="fas fa-print"></i> Cetak Draft</a> | 
              <a href=""><i class="fas fa-download"></i> Unduh</a>
            </div>
          </div>
          <form action="<?php echo site_url('production/purchase_order/updatePO') ?>" method="post" enctype="multipart/form-data" >
            <div class="card-body">

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Nomor PO</label><br>
                  <div class="badge badge-primary"><?= $po_data->po_code; ?></div>
                  <input type="hidden" class="form-control" name="ipo_id" value="<?=$po_data->po_id;?>">
                </div>
                <div class="form-group col-md-6">
                </div>
                <div class="form-group col-md-2">
                  <label>Dibuat pada</label>
                  <p style="color: #e41857; font-size: 14px; font-weight: 700;"><?= formatDMY($po_data->created_date); ?></p>
                  <input type="hidden" id="icreate_date" value="<?= $po_data->created_date ?>">
                </div>
              </div>
              <hr>
              <div class="card-body p-0" id="productMRP">
               <br>
               <div class="table-responsive">
                 <table id="tbvarian" class="table table-bordered">
                  <tr>
                    <th><div style="width: 220px;">Item</div></th>
                    <th><div style="width: 220px;">Supplier</div></th>
                    <th><div style="width: 220px;">Status</div></th>
                    <th><div style="width: 150px;">Jadwal Penerimaan</div></th>
                    <th><div style="width: 150px;">Leadtime</div></th>
                    <th><div style="width: 100px;">Jumlah</div></th>
                    <th><div style="width: 100px;">Satuan Unit</div></th>
                    <th><div style="width: 100px;">Harga Per Unit</div></th>
                    <th><div style="width: 100px;">Total Harga</div></th>
                  </tr>
                  <?php foreach($po_array as $dataPO):?>
                    <tr class="item_po">
                      <td>
                        <select class="form-control selitem_po" name="selitem_po[]">
                          <option value=""></option>
                          <?php foreach($material_list as $material):?>
                           <?php if(!empty($material->mv_option)) {   ?>
                            <option value="<?= $material->inv_id ?>" <?php if($material->inv_id == $dataPO->inv_id){echo "selected='selected'";} ?>>
                              <?= $material->material_name; ?> / <?= $material->mv_value ?>
                            </option>
                          <?php } else {  ?>
                            <option value="<?= $material->inv_id ?>" <?php if( $material->inv_id == $dataPO->inv_id){echo "selected='selected'";} ?>>
                              <?= $material->material_name; ?>
                            </option>
                          <?php }  ?>
                        <?php endforeach;?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control selitem_sup" name="selsupplier_po[]">
                        <option value=""></option>
                        <?php foreach($supplier as $suppliers):?>
                          <option value="<?php echo $suppliers->supplier_id ?>" <?php if($suppliers->supplier_id == $dataPO->supplier_id){echo "selected='selected'";} ?>>
                            <?php echo $suppliers->supplier_name; ?>
                          </option>
                        <?php endforeach;?>
                      </select>
                    </td>
                    <td>
                      <select class="form-control" name="istatus[]">
                       <?php if ($dataPO->status_po == "Sudah diterima"){?>
                        <option value="Sudah diterima" selected>Sudah diterima</option>
                        <option value="Belum diterima">Belum diterima</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                      <?php } ?>
                      <?php if ($dataPO->status_po == "Belum diterima"){?>
                        <option value="Sudah diterima">Sudah diterima</option>
                        <option value="Belum diterima" selected="">Belum diterima</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                      <?php } ?>
                      <?php if ($dataPO->status_po == "Dibatalkan"){?>
                        <option value="Sudah diterima">Sudah diterima</option>
                        <option value="Belum diterima">Belum diterima</option>
                        <option value="Dibatalkan" selected>Dibatalkan</option>
                      <?php } ?>
                    </select>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="idet_po_id[]" value="<?= $dataPO->id_det_po ?>">
                    <input type="date" class="form-control ischedule_receipt" name="ischedule_receipt[]" value="<?= $dataPO->schedule_receipt ?>" id="ischedule_receipt">
                  </td>
                  <td>
                    <div class="input-group">
                     <input type="text" class="form-control ileadtime" name="ileadtime" value="<?= $dataPO->leadtime ?>">
                     <div class="input-group-prepend">
                      <div class="input-group-text">
                        Hari
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <input type="text" class="form-control iqty_po amount" name="iqty_po[]" value="<?= $dataPO->quantity_po ?>" id="iqty">
                </td>
                <td>
                  <input type="text" style="text-align: center; color: white;" class="form-control iuom true" name="iuom[]" value="<?= $dataPO->material_unit ?>" id="iuom">
                </td>
                <td>
                  <input type="text" class="form-control iprice" name="iprice[]" id="iprice" value="<?= $dataPO->material_price ?>" readonly>
                </td>
                <td>
                  <input type="text" class="form-control isubtotal_price" name="isubtotal_price[]" id="isubtotal_price" readonly>
                </td>
              </tr>
            <?php endforeach;?>
          </table>
          <button class="btn btn-outline-primary" type="button" name="add" id="add"><i class="fa fa-plus-square"></i> Tambah Item</button>
          <br>
          <br>
        </div>
      </div>
      <div class="manufacturingloading" style="display: none;">
        <div class="content"><img src="<?php echo base_url('assets/img/pulse.gif'); ?>"/></div>
      </div>
      <br>
      <div class="form-row">
        <div class="form-group col-md-6">
        </div>
        <div class="form-group col-md-6">
          <label>Total Biaya</label>
          <input type="number" class="form-control igrand_total" name="igrand_total" id="igrand_total" value="<?= $po_data->total_cost  ?>" readonly>
        </div>
      </div>
      <hr>
      <div class="card-footer text-right">
        <a class="btn btn-light" href="<?php echo base_url(); ?>production/kontak">Batal</a> &nbsp;
        <button class="btn btn-success" type="submit" name="btn"><i class="fa fa-edit"></i> Perbarui</button>
        <button onclick="deleteConfirm('<?php echo base_url() ?>production/purchase_order/actdeletePO/<?= $po_data->po_id; ?>')" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Hapus Draft PO</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function() {
    addrows();
    deleterows();
    initailizeSelitemPO();
    initailizeSelitemSUP();
    sumtotalamount();
    ajaxData();

    var i = 1;
    function addrows()
    {
     $('#add').click(function(){  
      i++;  
      $('#tbvarian tbody').append('<tr id="row'+i+'" class="item_po"><td><select class="form-control selitem_po" name="selitem_po[]" id="selitem_po"><option value=""></option><?php foreach($material_list as $material):?><?php if(!empty($material->mv_option)){?><option value="<?= $material->inv_id ?>"><?= $material->material_name; ?> / <?= $material->mv_value ?> </option><?php } else {  ?><option value="<?= $material->inv_id?>"><?= $material->material_name; ?></option><?php } ?> <?php endforeach;?> </select></td><td><select class="form-control selitem_sup" name="selsupplier_po[]"><option value=""></option><?php foreach($supplier as $suppliers):?><option value="<?php echo $suppliers->supplier_id ?>"><?php echo $suppliers->supplier_name; ?></option><?php endforeach;?></select></td><td><select class="form-control" name="istatus[]"><option value="Belum diterima">Belum diterima</option> <option value="Sudah diterima">Sudah diterima</option><option value="Dibatalkan"> Dibatalkan</option> </select></td><td><input type="date" class="form-control ischedule_receipt" name="ischedule_receipt[]" id="ischedule_receipt"></td><td><div class="input-group"><input type="text" class="form-control ileadtime" name="ileadtime"><div class="input-group-prepend"><div class="input-group-text">Hari</div></div></div></td><td><input type="text" class="form-control iqty_po amount" name="iqty_po[]"></td><td><input type="text" style="text-align: center; color: white;" class="form-control iuom true" name="iuom[]"></td><td><input type="text" class="form-control iprice" name="iprice[]" readonly></td><td><input type="text" class="form-control isubtotal_price" name="isubtotal_price[]" readonly></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-trash"></button></td></tr>'); 
      initailizeSelitemPO();
      initailizeSelitemSUP();
      sumtotalamount();
      ajaxData();
    });
   }

   function deleterows()
   {
     $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();
      sumtotalamount();
    });
   }

   function initailizeSelitemPO(){
    $('.selitem_po').select2({
      width: '100%',
      placeholder: 'Pilih bahan baku',
      escapeMarkup: function (markup) { return markup; }
    });  
  }

  function initailizeSelitemSUP(){
    $('.selitem_sup').select2({
      width: '100%',
      placeholder: 'Pilih supplier',
      escapeMarkup: function (markup) { return markup; }
    });  
  }

  $(document).on("keyup", ".amount", sumtotalamount);

  function sumtotalamount() {
    $(".item_po").each(function () {
      var iqty            = 0;
      var iprice          = 0;
      var isubtotal_price = 0;
      if (!isNaN(parseFloat($(this).find(".iqty_po").val()))) {
        iqty = parseFloat($(this).find(".iqty_po").val());
      }
      if (!isNaN(parseFloat($(this).find(".iprice").val()))) {
        iprice  = parseFloat($(this).find(".iprice").val());
      }
      isubtotal_price = iqty * iprice;
      $(this).find(".isubtotal_price").val(isubtotal_price.toFixed());
    });

    var sum = 0;
    $(".isubtotal_price").each(function () {
      if (!isNaN(this.value) && this.value.length != 0) {
        sum += parseFloat(this.value);
      }
    });
    $("#igrand_total").val(parseFloat(sum.toFixed()));
  }

  function getPorel() {
    $('.item_po').each(function() {
     var dynamicfield = $(this).closest('tr');
     var leadtime = dynamicfield.find(".ileadtime").val()-0;
     var created_date = $('#icreate_date').val();
     
     var today = new Date(created_date); 
     today.setDate(today.getDate()+leadtime);
     var dd = today.getDate();
     var mm = today.getMonth()+1; 
     var yyyy = today.getFullYear(); 
     if (dd < 10) { dd = '0' + dd; } 
     if (mm < 10) { mm = '0' + mm; } 
     var today = yyyy+'-'+mm+'-'+dd; 
     dynamicfield.find('.ischedule_receipt').val(today);
   });
  }

  function ajaxData() {
    $('.selitem_po').change(function(){ 
      var dynamicfield = $(this).closest('tr');
      var inv_id=dynamicfield.find(".selitem_po").val();
      $.ajax({
        url : "<?php echo site_url('production/purchase_order/showmaterialAjax');?>",
        method : "POST",
        data : {inv_id: inv_id},
        async : true,
        dataType : 'json',
        success: function(data){
          leadtime       = data[0].leadtime;
          material_unit  = data[0].material_unit;
          material_price = data[0].material_price;

          dynamicfield.find(".ileadtime").val(leadtime);
          dynamicfield.find('.iuom').val(material_unit);
          dynamicfield.find('.iprice').val(material_price);
          sumtotalamount();
          getPorel();
        }
      });
      return false;
    }); 
  }

  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
  }

});
</script>

<script>
  function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deletePO').modal();
  }
</script>




<!-- Modal Delete Confirmation-->
<div class="modal fade" id="deletePO" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Draft PO yang terhapus, tidak akan bisa dikembalikan dan harus membuatkan ulang.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
      </div>
    </div>
  </div>
</div>


