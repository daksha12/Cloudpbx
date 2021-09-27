<div class="row"> 
  <div class="col-md-12">

    <table id="AllDatatable" class="table table-bordered table-striped example hoverable faq_list" >
      <thead>
      <tr>
          <th>Id</th>
          <th>Title</th>
          <th>Category</th>
          <th>Create Date</th>
          <th><center>Action</center></th>
      </tr>
      </thead>
      <tbody>
         <?php foreach($faqs as $value):?>                                 
          <tr>                               
              <td><?php echo $value->faq_id; ?></td>
               <td><?php echo $value->faq_title; ?></td>
              <td><?php echo $value->faq_category; ?></td>
              <td><?php echo $value->faq_created_at; ?></td>
                                                               
            <td>
              <a href="<?php echo site_url('Faq/faq/'.$value->faq_id); ?>">  
               <i class="fa fa-edit"></i>
               </a> | 
              <a href="<?php echo site_url('Faq/faq_delete/'.$value->faq_id); ?>" onclick="return confirm('Are you sure to delete this FAQ?');">  
                <i class="fa fa-trash"></i>
               </a>
              </td>
            </tr>  
          <?php endforeach; ?>                          
      </tbody>
  </table>              
 </div>
</div>