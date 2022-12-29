<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JeroenDesloovere\VCard\Property\Email;

//use JeroenDesloovere\VCard\Property\Company;
use JeroenDesloovere\VCard\Formatter\Formatter;
use JeroenDesloovere\VCard\Formatter\VcfFormatter;

use JeroenDesloovere\VCard\Exception\VCardException;
use JeroenDesloovere\VCard\Property\Address;
use JeroenDesloovere\VCard\Property\Anniversary;
use JeroenDesloovere\VCard\Property\Birthdate;
use JeroenDesloovere\VCard\Property\FullName;
use JeroenDesloovere\VCard\Property\Gender;
use JeroenDesloovere\VCard\Property\Logo;
use JeroenDesloovere\VCard\Property\Name;
use JeroenDesloovere\VCard\Property\Nickname;
use JeroenDesloovere\VCard\Property\NodeInterface;
use JeroenDesloovere\VCard\Property\Note;
use JeroenDesloovere\VCard\Property\Parameter\Kind;
use JeroenDesloovere\VCard\Property\Parameter\PropertyParameterInterface;
use JeroenDesloovere\VCard\Property\Parameter\Revision;
use JeroenDesloovere\VCard\Property\Parameter\Type;
use JeroenDesloovere\VCard\Property\Parameter\Version;
use JeroenDesloovere\VCard\Property\Photo;
use JeroenDesloovere\VCard\Property\PropertyInterface;
use JeroenDesloovere\VCard\Property\Role;
use JeroenDesloovere\VCard\Property\Telephone;
use JeroenDesloovere\VCard\Property\Title;

use JeroenDesloovere\VCard\VCard;

class ExportController extends Controller
{

    public function contacts(){
        $url = "https://api.canzell.com/__public__/user-service/users?";
        $response = file_get_contents($url);
        $newsData = json_decode($response);
        return  response()->json($newsData);
    }

    public function contact(String $name=null){
        $url = "https://api.canzell.com/__public__/user-service/users?";
        $response = file_get_contents($url);
        $newsData = json_decode($response);
        
        $newsData = collect($newsData);
        $singlecontact = $newsData->firstWhere('first_name', $name);
        return  response()->json($singlecontact);
    }

    public function vcf(String $name=null){
        $vcard = null;
        $formatter = new Formatter(new VcfFormatter(), 'vcard.export');


        $url = "https://api.canzell.com/__public__/user-service/users?";
        $response = file_get_contents($url);
        $newsData = json_decode($response);
        
        $newsData = collect($newsData);
        $singlecontact = $newsData->firstWhere('first_name', $name);

        $additional = '';
        $prefix = '';
        $suffix = '';

        $firstname=$singlecontact->first_name;
        $lastname = $singlecontact->last_name;
        $email = $singlecontact->email;
        $phone = $singlecontact->phone;
        $img = $singlecontact->mug;
        $role=$singlecontact->roles[0];

        // define vcard
        $vcard = new VCard();
        // add personal data
        $vcard->add(new Name($lastname, $firstname, $additional, $prefix, $suffix));
        $vcard->add(new Email($email));
        //$vcard->add(new Company('Siesqo'));
       // $vcard->addJobtitle('Web Developer');
        
        $vcard->add(new Role($role));
    //     
        if(isset($phone)){
            $vcard->add(new Telephone($phone));
        }
        
         $vcard->add(new Photo(public_path('contact.png')));

        //$vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);
        $formatter = new Formatter(new VcfFormatter(), 'vcard-export');
        $formatter->addVCard($vcard);
        return $formatter->download();

        //return "LAst name: ".$role;
    }
}
