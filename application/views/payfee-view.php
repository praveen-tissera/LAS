<?php

if (!($this->session->userdata('user_detail'))) {

  redirect('/user/login');
} else {
  $user_detail = $this->session->userdata('user_detail');
  
}


?>


<!-- load navigatio resouces -->
<?php $this->load->view('header'); ?>
<?php $this->load->view('top-navigation'); ?>
<?php $this->load->view('staff-navigation'); ?>



<br>

<div class="container">
  <div class="row">
    <div class="col-12">
    <?php

    if (isset($error_message_display)) {
      echo '<div class="alert alert-danger" role="alert">';
      echo $error_message_display;
      echo '</div>';
    }
    if (isset($success_message_display)) {
      echo '<div class="alert alert-success" role="alert">';
      echo $success_message_display;
      echo '</div>';
    }

    ?>
    </div>
  </div>
    <?php 
    // print_r($studentManagement);
    
    if(isset($this->session->userdata('user_detail')['user-wise-menu'])){
      $userMenu = $this->session->userdata('user_detail')['user-wise-menu'];
          

          
  }
    
    ?>
    <div class="row">
    <?php 
    if(isset($all_batches)){
      echo form_open("user/feeManage/{$studentId}/{$courseId}/2"); 
    }
   
    ?>
    <div class="col-12">
    <h2>Student Search</h2>
    <div class="form-row">
      
        <div class="form-group col-md-12">
          
          <?php 
          // print_r($history);
        
  foreach ($courses as $key => $course) {
    // print_r($course);
    echo "<a href='". base_url('user/feeManage'). "/{$course->student_id}/{$course->batch_object->course_id}/1' class='btn btn-warning'>Pay Now ({$course->batch_object->course_detail->course_name})</a>";
  }

          foreach ($history as $key => $batch) {
            echo '<h5>'. $batch->batch_object->batch_number . '<h5>';
            echo "<input type='text' id='{$batch->batch_object->batch_id}' value='{$batch->batch_object->course_detail->course_fee}'>";
           
            echo "<table class='table'>";
              echo "<tr>";
                echo "<th>Month</th><th>Receipt Number</th><th>Paid Amount</th><th>Paid Date</th>";
              echo "</tr>";

              foreach ($batch->payment_object as $key => $payment) {
                echo "<tr>";
                  echo "<td>";
                    echo $payment->pay_month;
                  echo "</td>";
                
                  echo "<td>";
                    echo $payment->payment_receive->receipt_number;
                    // print_r($payment->payment_receive);
                  echo "</td>";
                  echo "<td>";
                    echo $payment->payment_receive->paid_amount;
                  echo "</td>";
                  echo "<td>";
                  echo $payment->payment_receive->paid_date;
                echo "</td>";
                echo "</tr>";
              }
            echo "</table>";

          }
          ?>
          <?php 
          if(isset($all_batches)){
            $month_array = ['January','February','March','April','June','July','August','September','Octmber','November','December'];
            echo "<select name='selected_course' class='form-control'>";
          
            foreach ($month_array as $key_course => $month) {
              // print_r($course);
              echo "<option value='{$month}'>";
              echo $month;
              echo "</option>";
            }
            echo "</select>";
            foreach ($all_batches as $key_batch => $batch) {
              // print_r($course);
              $batchid = 20;
              $js = 'onClick="feeCalculation(' . $select_course[0]->course_fee .')"';
              echo form_checkbox('completed[]',$batch->batch_id, FALSE,$js);
              // echo "<input type='checkbox' value='{$batch->batch_id}'>";
              echo "<label>" . $batch->batch_number. " (commence date: " . $batch->commence_date . ") </label>";
             echo "<br>";
            }
            $js = 'onClick="feeCalculation(100)"';
            echo form_checkbox('completed[]',$batch->batch_id, FALSE,$js);
              
              echo "<label>" . 'Institute Fee'. " </label>";
            echo '
            <div class="form-group">
          <label>Total Fee</label>
          <input type="text" class="form-control" id="totalFee" name="total-fee" readonly>

        </div>';
  
  
            echo '<button type="submit" class="form-group btn btn-primary">Pay Now</button>';
          }
         
          ?>



        </div>
      <?php echo form_close(); ?>
  </div>
  </div>
    </div>

 



</div>






<?php $this->load->view('footer'); ?>
<script>
   var classFee = 0;
    function feeCalculation(amount){
      classFee = classFee + amount;
      $('#totalFee').val(classFee);
    }
  $(document).ready(function(){
   
    $('#due-date').hide();
    $('#pay_mode').on('change',function(){
      var installment = $(this).val();
      if(installment == '1st installment'){
        $('#due-date').show();
      }else{
        $('#due-date').hide();
      }
    });
  });
</script>