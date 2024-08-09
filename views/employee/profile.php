<?php $user = $data ? $data->user : null;?>
<div class="container-fluid px-4">
    <h4 class="mt-4">Profile</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item ">Profile</li>
    </ol>
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="name" type="text" class="form-control" value="<?= $user->first_name. ' ' .$user->last_name ?>" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" value="<?= $user->email ?>" />
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="editUserBio" class="form-control">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid unde at fugiat explicabo temporibus, tempora animi sunt iusto quod beatae optio veritatis velit natus odit error! Possimus esse quisquam quibusdam eveniet autem! Minus dolore quisquam nemo similique doloribus perspiciatis tempore.
                  </textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <img src="/views/assets/img/avatar.png" class="d-block img-fluid mb-3">
            <button class="btn btn-primary btn-block">Update</button>
            <button class="btn btn-danger btn-block">Delete</button>
        </div>
    </div>
</div>