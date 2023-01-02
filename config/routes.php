<?php

namespace app;

Router::addRoute("/", "BaseController::index");
Router::addRoute("/photos", "photos\PhotosController::index");
Router::addRoute("/photos", "photos\PhotosController::create", "POST");
Router::addRoute("/photos/{id}", "photos\PhotosController::show");
Router::addRoute("/signup", "UsersController::create", "POST");
Router::addRoute("/signup", "UsersController::new");
Router::addRoute("/signin", "UsersController::createSession", "POST");
Router::addRoute("/signin", "UsersController::newSession");
Router::addRoute("/logout", "UsersController::destroySession");
Router::addRoute("/favourites", "FavouritesController::index");
Router::addRoute("/favourites", "FavouritesController::create", "POST");
Router::addRoute("/favourites", "FavouritesController::destroy", "DELETE");
Router::addRoute("/search", "SearchController::index");
