<?php

namespace Controllers;


use Core\Services\Authentication\AuthenticationServiceInterface;
use Core\Services\User\UserServiceInterface;
use DTO\LoginUserBindingModel;
use DTO\ProfileEditBindingModel;
use DTO\ProfileEditViewModel;
use DTO\RegisterUserBindingModel;
use ViewEngine\ViewInterface;

class Users
{
    public function hello(string $firstName, string $lastName, ViewInterface $view)
    {
        $viewModel = new ProfileEditBindingModel($firstName, $lastName);
        $view->render($viewModel);
    }

    public function edit($id, ProfileEditBindingModel $model, ViewInterface $view)
    {
        $viewModel = new ProfileEditViewModel(
            $id,
            $model->getUsername(),
            $model->getPassword(),
            $model->getEmail(),
            $model->getBirthday()
        );
        $view->render($viewModel);
    }

    public function register(ViewInterface $view)
    {
        return $view->render();
    }

    public function registerPost(UserServiceInterface $userService,
                                 RegisterUserBindingModel $bindingModel)
    {
        if ($userService->register($bindingModel->getUsername(), $bindingModel->getPassword())) {
            header("Location: /mvc/users/login");
            exit();
        }
        header("Location: /mvc/users/register");
    }

    public function login(ViewInterface $view)
    {
        return $view->render();
    }

    public function loginPost(AuthenticationServiceInterface $authenticationService,
                            LoginUserBindingModel $bindingModel)
    {
        if ($authenticationService->login(
            $bindingModel->getUsername(),
            $bindingModel->getPassword()
        )) {
            header("Location: /mvc/users/profile");
            exit();
        }
        header("Location: /mvc/users/login");
    }


}