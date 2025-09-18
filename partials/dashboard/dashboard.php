<div class="stats">
    <h1>Hello <b><?= auth()->user()->firstName ?? explode(auth()->user()->email, "@")[0]?></b></h1>
    <div class="stats-container">
        <?php echo $statistics; ?>
    </div>
</div>

 <!-- Previous Jobs preview -->
 <div class="container-fluid mt-5">
     <div class="d-flex justify-content-between align-items-center my-2">
         <h2>Recent Activities</h2>
         <a class="btn btn-outline-danger btn-sm"
             href="<?= auth()->hustlerStatus()->isHustler
             ? '/hustler/requests'
             : '/client/activities' ?>">
             View More
         </a>
     </div>

     <div class="card table-responsive-md" id="client-activities-preview">
         <table class="table table-striped table-hover">
             <thead>
                 <tr>
                     <th>Title</th>
                     <th>Description</th>
                     <th class="d-none d-md-table-cell">Created At</th>
                     <th class="d-none d-md-table-cell">Start Date</th>
                     <th>Status</th>
                 </tr>
             </thead>
             <tbody>
                 <tr>
                     <td colspan="3" class="d-md-none text-center">Loading...</td>
                     <td colspan="5" class="d-none d-md-table-cell text-center">Loading...</td>
                 </tr>
             </tbody>
         </table>
     </div>
 </div>
