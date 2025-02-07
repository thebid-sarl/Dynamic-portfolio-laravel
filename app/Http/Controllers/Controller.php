<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Person;

use Carbon\Carbon; // Include Class in COntroller
use Exception;

use function PHPUnit\Framework\isReadable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->repository = new Repository();
    }

    // public function personIsExist()
    // {
    //     if (count($this->repository->getPerson()) == 0) {
    //         return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
    //     }
    // }

    public function home()
    {
        //person
        $person = [];
        $age = "";
        $phone = "";
        $personArray = $this->repository->getPerson();
        if (count($personArray) != 0) {

            $person = $personArray[0];
            $age = Carbon::parse($person->birthday)->diff(Carbon::now())->y;

            $phone = str_replace(' ', '', $person->phone);

            //dd($age, $phone);
        }

        //Experiences
        $experiences = $this->repository->getExperiences();

        //Formations
        $formations = $this->repository->getFormations();

        //Skills
        $skills = $this->repository->getSkills();

        //Certificates
        $certificates = $this->repository->getCertificates();

        //dd($certificates);

        return view('home', [
            'person' => $person,
            'age' => $age,
            'phone' => $phone,
            'experiences' => $experiences,
            'formations' => $formations,
            'skills' => $skills,
            'certificates' => $certificates
        ]);
    }

    //Connection 
    public function loginShow()
    {
        if (!request()->session()->has('user')) {
            return view('admin');
        }
        return redirect()->route('list.show');
    }

    public function login()
    {
        $rules = [
            'id' => ['required', 'exists:superuser,id'],
            'password' => ['required']
        ];

        $messages = [
            'id.required' => "Vous devez saisir l'id de l'admin.",
            'id.exists' => "Cet administrateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];

        $validatedData = request()->validate($rules, $messages);
       

        try {
            # lever une exception si le mot de passe de l'utilisateur n'est pas correct
            $user = $this->repository->getSuperUser($validatedData['id'], $validatedData['password']);
           
            # se souvenir de l'authentification de l'utilisateur
            request()->session()->put('user', $user);
         

            return redirect()->route('list');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Mot de passe incorrecte.");
        }
    }

    //Deconnexion
    public function logout()
    {
        request()->session()->forget('user');

        return redirect()->route('login.show');
    }

    public function toggleLike(Request $request)
    {
        try {
            $ip = $request->ip();         
            $like = Like::where('ip_address', $ip)->first();
            if ($like) {
                $like->update(['has_liked' => !$like->has_liked]);
                return response()->json(['message' => 'Like mis à jour', 'has_liked' => $like->has_liked]);
            }
            Like::create(['ip_address' => $ip, 'has_liked' => true]);
            return response()->json(['message' => 'Like ajouté', 'has_liked' => true]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    //Create Profil
    public function showCreateProfil()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        //person is exist ?
        if (count($this->repository->getPerson()) != 0) {
            return redirect()->route('list.show')->with('warning', 'vous avez déjà un profile, impossible d\'en créer un à nouveau !');
        }
        return view('create_profil');
    }

    public function createProfil()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'birthday' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'degree' => ['required'],
            'domain' => ['required'],
            'presentation' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
        ];

        $messages = [
            'firstname.required' => "Vous devez saisir votre prenom",
            'lastname.required' => "Entrer un nom de famille",
            'birthday.required' => "Entrer votre  date de naissance",
            'email.required' => "Entrer votre adresse mail",
            'phone.required' => "Entrer votre numéro de téléphone",
            'degree.required' => "Entrer votre niveau d'étude",
            'domain.required' => "Entrer votre domaine d'étude ou de travail",
            'presentation.required' => "Presentez vous brievement.",
            'country.required' => "Entrer votre pays de résidence",
            'city.required' => "Entrer votre ville de résidence.",
        ];

        $validatedData = request()->validate($rules, $messages);

        $firstname = $validatedData['firstname'];
        $lastname = $validatedData['lastname'];
        $birthday = $validatedData['birthday'];
        $email = $validatedData['email'];
        $phone = $validatedData['phone'];
        $degree = $validatedData['degree'];
        $domain = $validatedData['domain'];
        $presentation = $validatedData['presentation'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $idSuperUser = session()->get('user')['id'];
       

        //socials networks
        $github =  request()->input('github');
        $twitter =  request()->input('twitter');
        $skype =  request()->input('skype');
        $linkedin =  request()->input('linkedin');

        if($github==null) $github = "";
        if($twitter==null) $twitter = "";
        if($skype==null) $skype = "";
        if($linkedin==null) $linkedin = "";
        //dd($github, $twitter, $skype, $linkedin);


        //create unique filename image header and add new path image if is posible
        $headerImagePath = "";
        if (request()->headerImage == null) {
            $headerImagePath = "https://bootdey.com/img/Content/avatar/avatar7.png";
        } else {
            $filename = time() . '.' . request()->headerImage->extension();
            //put image into storage folder and get path
            $headerImagePath = request()->file('headerImage')->storeAs('PersonImages', $filename, 'public');
        }

        //create unique filename image about and add new path image if is posible
        $aboutImagePath = "";
        if (request()->aboutImage == null) {
            $aboutImagePath = "default/about.jpg";
        } else {
            $filename = time() . '.' . request()->aboutImage->extension();
            //put image into storage folder and get path
            $aboutImagePath = request()->file('aboutImage')->storeAs('PersonImages', $filename, 'public');
        }

        //create unique filename image about and add new path image if is posible
        $coverImagePath = "";
        if (request()->coverImage == null) {
            $coverImagePath = "default/cover.jpg";
        } else {
            $filename = time() . '.' . request()->coverImage->extension();
            //put image into storage folder and get path
            $coverImagePath = request()->file('coverImage')->storeAs('PersonImages', $filename, 'public');
        }

        try {
            $this->repository->createPerson(
                $firstname,
                $lastname,
                $birthday,
                $email,
                $phone,
                $degree,
                $country,
                $city,
                $headerImagePath,
                $coverImagePath,
                $aboutImagePath,
                $domain,
                $presentation,
                $github,
                $twitter,
                $skype,
                $linkedin,
                $idSuperUser
            );
            return redirect()->route('list.show')->with('message', 'Profil créer avec succès !');
        } catch (Exception $e) {
           
            return redirect()->back();
        }
    }

    //Update Profil
    public function showUpdateProfil()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $person = $this->repository->getPerson()[0];
        // dd($person);
        return view('update_profil', ['person' => $person]);
    }

    public function updateProfil()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'birthday' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'degree' => ['required'],
            'domain' => ['required'],
            'presentation' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
        ];

        $messages = [
            'firstname.required' => "Vous devez saisir votre prenom",
            'lastname.required' => "Entrer un nom de famille",
            'birthday.required' => "Entrer votre  date de naissance",
            'email.required' => "Entrer votre adresse mail",
            'phone.required' => "Entrer votre numéro de téléphone",
            'degree.required' => "Entrer votre niveau d'étude",
            'domain.required' => "Entrer votre domaine d'étude ou de travail",
            'presentation.required' => "Presentez vous brievement.",
            'country.required' => "Entrer votre pays de résidence",
            'city.required' => "Entrer votre ville de résidence.",
        ];

        $validatedData = request()->validate($rules, $messages);

        $firstname = $validatedData['firstname'];
        $lastname = $validatedData['lastname'];
        $birthday = $validatedData['birthday'];
        $email = $validatedData['email'];
        $phone = $validatedData['phone'];
        $degree = $validatedData['degree'];
        $domain = $validatedData['domain'];
        $presentation = $validatedData['presentation'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];

        //socials networks
        $github =  request()->input('github');
        $twitter =  request()->input('twitter');
        $skype =  request()->input('skype');
        $linkedin =  request()->input('linkedin');

        if($github==null) $github = "";
        if($twitter==null) $twitter = "";
        if($skype==null) $skype = "";
        if($linkedin==null) $linkedin = "";
        //dd($github, $twitter, $skype, $linkedin);

        $idSuperUser = session()->get('user')['id'];
        $person = $this->repository->getPerson()[0];
        //create unique filename image header and add new path image if is posible
        $headerImagePath = "";
        if (request()->headerImage == null) {
            $headerImagePath = $person->headerImage;
        } else {
            //exception image
            if (!is_file(request()->file('headerImage')) || !isReadable(request()->file('headerImage')))
                return redirect()->back()->withInput()->withErrors('Taille d\'image d\'entête trop élevée !');

            $filename = time() . '.' . request()->headerImage->extension();
            //put image into storage folder and get path
            $headerImagePath = request()->file('headerImage')->storeAs('PersonImages', $filename, 'public');
        }

        //create unique filename image about and add new path image if is posible
        $aboutImagePath = "";
        if (request()->aboutImage == null) {
            $aboutImagePath = $person->aboutImage;
        } else {
            //exception image
            if (!is_file(request()->file('aboutImage')) || !is_readable(request()->file('aboutImage')))
                return redirect()->back()->withInput()->withErrors('Taille d\'image d\apropos trop élevée !');

            $filename = time() . '.' . request()->aboutImage->extension();
            //put image into storage folder and get path
            $aboutImagePath = request()->file('aboutImage')->storeAs('PersonImages', $filename, 'public');
        }

        //create unique filename image about and add new path image if is posible
        $coverImagePath = "";
        if (request()->coverImage == null) {
            $coverImagePath = $person->coverImage;
        } else {
            //exception image
            if (!is_file(request()->file('coverImage')) || !is_readable(request()->file('coverImage')))
                return redirect()->back()->withInput()->withErrors('Taille d\'image de couverture trop élevée !');

            $filename = time() . '.' . request()->coverImage->extension();

            //put image into storage folder and get path
            $coverImagePath = request()->file('coverImage')->storeAs('PersonImages', $filename, 'public');
        }
        //dd($headerImagePath, $coverImagePath, $aboutImagePath);
        try {
            $this->repository->updatePerson(
                $firstname,
                $lastname,
                $birthday,
                $email,
                $phone,
                $degree,
                $country,
                $city,
                $headerImagePath,
                $coverImagePath,
                $aboutImagePath,
                $domain,
                $presentation,
                $github,
                $twitter,
                $skype,
                $linkedin,
                $idSuperUser
            );
            return redirect()->route('list.show')->with('message', 'Profil modifier avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Modification de profil echouée !');
        }
    }

    //Delete Profil
    public function deleteProfil()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $idSuperUser = session()->get('user')['id'];
        $this->repository->deletePerson($idSuperUser);
        return redirect()->route('list.show')->with('warning', 'Profil et toutes ses dépendances supprimé avec succès !');
    }

    public function addShowExperience()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        //person is exist ?
        if (count($this->repository->getPerson()) == 0) {
            return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
        }

        return view('create_experience');
    }

    public function addExperience()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'beginDate' => ['required'],
            'endDate' => ['required'],
            'companyName' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'beginDate.required' => "Entrer la date de début",
            'endDate.required' => "Entrer la date de fin",
            'companyName.required' => "Entrer le nom de l'ecole ou de l'université",
            'country.required' => "Entrer le pays de la formation",
            'city.required' => "Entrer la ville de la formation",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $beginDate = $validatedData['beginDate'];
        $endDate = $validatedData['endDate'];
        $companyName = $validatedData['companyName'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $description = $validatedData['description'];

        // dd($title, $beginDate, $endDate, $companyName, $country, $city, $description);

        $idPerson = $this->repository->getPerson()[0]->id;
        //dd($idPerson);
        try {
            $this->repository->addExperience($idPerson, $title, $beginDate, $endDate, $companyName, $country, $city, $description);
            return redirect()->route('list.show')->with('message', 'Expérience ajoutée avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Ajout d\'Expérience echoué !');
        }
    }

    //Update Formation
    public function updateShowExperience($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        //person is exist ?
        if (count($this->repository->getPerson()) == 0) {
            return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
        }

        $experience = $this->repository->getExperienceById($id)[0];

        return view('update_experience', ['experience' => $experience]);
    }

    public function updateExperience($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'beginDate' => ['required'],
            'endDate' => ['required'],
            'companyName' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'beginDate.required' => "Entrer la date de début",
            'endDate.required' => "Entrer la date de fin",
            'companyName.required' => "Entrer le nom de l'ecole ou de l'université",
            'country.required' => "Entrer le pays de la formation",
            'city.required' => "Entrer la ville de la formation",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $beginDate = $validatedData['beginDate'];
        $endDate = $validatedData['endDate'];
        $companyName = $validatedData['companyName'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $description = $validatedData['description'];

        // dd($title, $beginDate, $endDate, $companyName, $country, $city, $description);

        try {
            $this->repository->updateExperience($id, $title, $beginDate, $endDate, $companyName, $country, $city, $description);
            return redirect()->route('list.show')->with('message', 'Expérience mis à jour avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('mis à jour d\'Expérience echoué !');
        }
    }

    //Delete Formation
    public function deleteExperience($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }
        $title = $this->repository->getExperienceById($id)[0]->title;

        $this->repository->deleteExperience($id);
        return redirect()->route('list.show')->with('message', 'Expérience : "' . $title . '" supprimée avec succès !');
    }
    //============================End Experience section ===========================//


    //============================Formation ===========================//
    public function addShowFormation()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }
        //person is exist ?
        if (count($this->repository->getPerson()) == 0) {
            return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
        }

        return view('create_formation');
    }

    public function addFormation()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'beginDate' => ['required'],
            'endDate' => ['required'],
            'schoolName' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'beginDate.required' => "Entrer la date de début",
            'endDate.required' => "Entrer la date de fin",
            'schoolName.required' => "Entrer le nom de l'ecole ou de l'université",
            'country.required' => "Entrer le pays de la formation",
            'city.required' => "Entrer la ville de la formation",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $beginDate = $validatedData['beginDate'];
        $endDate = $validatedData['endDate'];
        $schoolName = $validatedData['schoolName'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $description = $validatedData['description'];

        //dd($title, $beginDate, $endDate, $schoolName, $country, $city, $description);

        $idPerson = $this->repository->getPerson()[0]->id;
        //dd($idPerson);
        try {
            $this->repository->addFormation($idPerson, $title, $beginDate, $endDate, $schoolName, $country, $city, $description);
            return redirect()->route('list.show')->with('message', 'Formation ajoutée avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Ajout de Formation echoué !');
        }
    }

    //Update Formation
    public function updateShowFormation($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        //person is exist ?
        if (count($this->repository->getPerson()) == 0) {
            return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
        }

        $formation = $this->repository->getFormationById($id)[0];

        return view('update_formation', ['formation' => $formation]);
    }

    public function updateFormation($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'beginDate' => ['required'],
            'endDate' => ['required'],
            'schoolName' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'beginDate.required' => "Entrer la date de début",
            'endDate.required' => "Entrer la date de fin",
            'schoolName.required' => "Entrer le nom de l'ecole ou de l'université",
            'country.required' => "Entrer le pays de la formation",
            'city.required' => "Entrer la ville de la formation",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $beginDate = $validatedData['beginDate'];
        $endDate = $validatedData['endDate'];
        $schoolName = $validatedData['schoolName'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $description = $validatedData['description'];

        //dd($id, $title, $beginDate, $endDate, $schoolName, $country, $city, $description);

        try {
            $this->repository->updateFormation($id, $title, $beginDate, $endDate, $schoolName, $country, $city, $description);
            return redirect()->route('list.show')->with('message', 'Formation mis à jour avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('mis à jour de Formation echoué !');
        }
    }

    //Delete Formation
    public function deleteFormation($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }
        $title = $this->repository->getFormationById($id)[0]->title;

        $this->repository->deleteFormation($id);
        return redirect()->route('list.show')->with('message', 'Formation : "' . $title . '" supprimée avec succès !');
    }
    //============================End Formation section ===========================//


    //============================Skill===========================//
    public function addShowSkill()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        //person is exist ?
        if (count($this->repository->getPerson()) == 0) {
            return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
        }

        return view('create_skill');
    }

    public function addSkill()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $description = $validatedData['description'];

        //dd($title, $description);

        $idPerson = $this->repository->getPerson()[0]->id;
        //dd($idPerson);
        try {
            $this->repository->addSkill($idPerson, $title, $description);
            return redirect()->route('list.show')->with('message', 'Compétence créer avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Création de compétence echouée !');
        }
    }

    //Update certification
    public function updateShowSkill($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $skill = $this->repository->getSkillById($id)[0];

        return view('update_skill', ['skill' => $skill]);
    }

    public function updateSkill($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $description = $validatedData['description'];

        try {
            $this->repository->updateSkill($id, $title, $description);
            return redirect()->route('list.show')->with('message', 'Compétence mis à jour avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('mis à jour de compétence echouée !');
        }
    }

    //Delete skill
    public function deleteSkill($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }
        $title = $this->repository->getSkillById($id)[0]->title;

        $this->repository->deleteSkill($id);
        return redirect()->route('list.show')->with('message', 'Compétence : "' . $title . '" supprimée avec succès !');
    }

    //============================End Skill section ===========================//


    //============================Certificates====================//
    public function addShowCertification()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }
        //person is exist ?
        if (count($this->repository->getPerson()) == 0) {
            return redirect()->route('createProfil.show')->with('warning', 'vous n\'avez encore créer de profile !');
        }

        return view('create_certification');
    }

    public function addCertification()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'receiptDate' => ['required'],
            'organizationName' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'receiptDate.required' => "Entrer la date d'obtention",
            'organizationName.required' => "Entrer le nom de l'organisme ou de la plateforme",
            'country.required' => "Entrer le pays d'obtention",
            'city.required' => "Entrer la ville d'obtention",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $receiptDate = $validatedData['receiptDate'];
        $organizationName = $validatedData['organizationName'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $description = $validatedData['description'];

        //dd($title, $receiptDate, $organizationName, $country, $city, $description);

        $idPerson = $this->repository->getPerson()[0]->id;
        //dd($idPerson);
        try {
            $this->repository->addCertificate($idPerson, $title, $receiptDate, $organizationName, $country, $city, $description);
            return redirect()->route('list.show')->with('message', 'Certification créer avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Création de certification echouée !');
        }
    }

    //Update certification
    public function updateShowCertification($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $certificate = $this->repository->getCertificateById($id)[0];

        return view('update_certification', ['certificate' => $certificate]);
    }

    public function updateCertification($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        $rules = [
            'title' => ['required'],
            'receiptDate' => ['required'],
            'organizationName' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'description' => ['required']
        ];

        $messages = [
            'title.required' => "Vous devez saisir un titre",
            'receiptDate.required' => "Entrer la date d'obtention",
            'organizationName.required' => "Entrer le nom de l'organisme ou de la plateforme",
            'country.required' => "Entrer le pays d'obtention",
            'city.required' => "Entrer la ville d'obtention",
            'description.required' => "Entrer une description"
        ];

        $validatedData = request()->validate($rules, $messages);

        $title = $validatedData['title'];
        $receiptDate = $validatedData['receiptDate'];
        $organizationName = $validatedData['organizationName'];
        $country = $validatedData['country'];
        $city = $validatedData['city'];
        $description = $validatedData['description'];

        // dd($title, $receiptDate, $organizationName, $country, $city, $description);

        // $idPerson = $this->repository->getPerson()[0]->id;
        //dd($idPerson);
        try {
            $this->repository->updateCertificate($id, $title, $receiptDate, $organizationName, $country, $city, $description);
            return redirect()->route('list.show')->with('message', 'Certification modifier avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Modification de certification echouée !');
        }
    }

    public function deleteCertification($id)
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }
        $title = $this->repository->getCertificateById($id)[0]->title;

        $this->repository->deleteCertificate($id);
        return redirect()->route('list.show')->with('message', 'Certfication : "' . $title . '" supprimée avec succès !');
    }

    //============================End Certificates section ===========================//


    //============================List===========================//
    public function list()
    {
        if (!request()->session()->has('user')) {
            return redirect()->route('login.show');
        }

        //person
        $person = [];
        $name = "";
        $personArray = $this->repository->getPerson();
        if (count($personArray) != 0) {

            $name = $personArray[0]->firstname;
        }

        //Experiences
        $experiences = $this->repository->getExperiences();

        //Formations
        $formations = $this->repository->getFormations();

        //Skills
        $skills = $this->repository->getSkills();

        //Certificates
        $certificates = $this->repository->getCertificates();

        return view('list', [
            'name' => $name,
            'experiences' => $experiences,
            'formations' => $formations,
            'skills' => $skills,
            'certificates' => $certificates
        ]);
    }
    //============================End List section ===========================//

   
}
