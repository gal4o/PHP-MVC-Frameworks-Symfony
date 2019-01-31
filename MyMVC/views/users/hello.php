<?php /** @var \DTO\ProfileEditBindingModel $model */ ?>

<h1>Hello Mr/Ms <?= $model->getUsername(); ?></h1>

<div class="well bs-component">
    <form action="/mvc/users/edit/4" method="post">
        <div class="form-control">
            <label for="username">Username:</label>
            <input type="text" name="username" id="usernsme">
        </div>
        <div class="form-control">
            <label for="password">Password:</label>
            <input type="text" name="password" id="password">
        </div>
        <div class="form-control">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email"
        </div>
        <div class="form-control">
            <label for="birthday">Birthday:</label>
            <input type="date" name="birthday" id="birthday"
        </div>
        <div class="form-control">
        <button class="button" type="submit">Edit</button>
        </div>
    </form>
</div>