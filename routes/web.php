<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Portfolio Accueil
Route::get('/', [Controller::class, 'home'])->name('home');

//========================Profil=======================//
//create Profil
Route::get('/create-profil', [Controller::class, 'showCreateProfil'])->name('createProfil.show');
Route::post('/create-profil', [Controller::class, 'createProfil'])->name('createProfil.post');

//update Profil
Route::get('/update-profil', [Controller::class, 'showUpdateProfil'])->name('updateProfil.show');
Route::post('/update-profil', [Controller::class, 'updateProfil'])->name('updateProfil.post');

//delete Profil
Route::post('/delete-profil', [Controller::class, 'deleteProfil'])->name('deleteProfil.post');
//========================End Profil=======================//


//========================Experiences=======================//
//add experience
Route::get('/add-experience', [Controller::class, 'addShowExperience'])->name('addExperience.show');
Route::post('/add-experience', [Controller::class, 'addExperience'])->name('addExperience.post');

//Update experience
Route::get('/update-experience/{id}', [Controller::class, 'updateShowExperience'])->name('updateExperience.show');
Route::post('/update-experience/{id}', [Controller::class, 'updateExperience'])->name('updateExperience.post');

//delete experience
Route::post('/delete-experience/{id}', [Controller::class, 'deleteExperience'])->name('deleteExperience.post');
//========================End Experiences=======================//


//========================Formations=======================//
//add formation
Route::get('/add-formation', [Controller::class, 'addShowFormation'])->name('addFormation.show');
Route::post('/add-formation', [Controller::class, 'addFormation'])->name('addFormation.post');

//Update Formation
Route::get('/update-formation/{id}', [Controller::class, 'updateShowFormation'])->name('updateFormation.show');
Route::post('/update-formation/{id}', [Controller::class, 'updateFormation'])->name('updateFormation.post');

//delete Formation
Route::post('/delete-formation/{id}', [Controller::class, 'deleteFormation'])->name('deleteFormation.post');
//========================End Formations=======================//


//========================Skills=======================//
//Add skill
Route::get('/add-skill', [Controller::class, 'addShowSkill'])->name('addSkill.show');
Route::post('/add-skill', [Controller::class, 'addSkill'])->name('addSkill.post');

//Update skill
Route::get('/update-skill/{id}', [Controller::class, 'updateShowSkill'])->name('updateSkill.show');
Route::post('/update-skill/{id}', [Controller::class, 'updateSkill'])->name('updateSkill.post');

//delete skill
Route::post('/delete-skill/{id}', [Controller::class, 'deleteSkill'])->name('deleteSkill.post');
//========================End Skills=======================//


//========================Certificates=======================//
//Add Certification
Route::get('/add-certification', [Controller::class, 'addShowCertification'])->name('addCertification.show');
Route::post('/add-certification', [Controller::class, 'addCertification'])->name('addCertification.post');

//Update Certification
Route::get('/update-certification/{id}', [Controller::class, 'updateShowCertification'])->name('updateCertification.show');
Route::post('/update-certification/{id}', [Controller::class, 'updateCertification'])->name('updateCertification.post');

//delete Certification
Route::post('/delete-certification/{id}', [Controller::class, 'deleteCertification'])->name('deleteCertification.post');
//========================End Certificates=======================//


//========================List=======================//
Route::get('/list', [Controller::class, 'list'])->name('list.show');
//========================End list=======================//


//========================Login/logout=======================//
Route::get('/login', [Controller::class, 'loginShow'])->name('login.show');
Route::post('/login', [Controller::class, 'login'])->name('login.post');
Route::post('/logout', [Controller::class, 'logout'])->name('logout');
//========================End Login/logout=======================//

Route::get('/visits', [VisitController::class, 'index']);

Route::post('/toggle-like', [Controller::class, 'toggleLike']);