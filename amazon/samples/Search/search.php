<?php
/*
 * Copyright 2013 Jan Eichhorn <exeu65@googlemail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Config.php';

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
			      
//function caca($search)
//{
			      $conf = new GenericConfiguration();
   
   try {
      $conf
	 ->setCountry('fr')
	 ->setAccessKey(AWS_API_KEY)
	 ->setSecretKey(AWS_API_SECRET_KEY)
	 ->setAssociateTag(AWS_ASSOCIATE_TAG)
	 ->setRequest('\ApaiIO\Request\Soap\Request')
	 ->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

   } catch (\Exception $e) {
      echo $e->getMessage();
   }
   $apaiIO = new ApaiIO($conf);

   $search = new Search();
   $search->setCategory('All');
   $search->setKeywords($search);
   $search->setPage(3);
   $search->setResponseGroup(array('Large', 'Small'));


   $formattedResponse = $apaiIO->runOperation($search);


   $items = $formattedResponse['Items']['Item'];

   $compteur = 3;
   foreach ($items as $item) {
      if($compteur > 0){
	 $features = $item['ItemAttributes'];
	 echo $features['Title'];	
	 $image = $item['MediumImage'];
	 $img = $image['URL']; 
	 echo '<img src='.$img.' alt="Photo Absente"/>';
	 $descrip = ' ';
	 foreach ($features['Feature'] as $var) {
	    $descrip .= '<br/>' .$var;
	 }
	 echo $descrip;
	 $compteur--;
      }
   }

//}

//caca('string');
/*
   'Offers' => 
        array (size=4)
          'TotalOffers' => int 1
          'TotalOfferPages' => int 1
          'MoreOffersUrl' => string 'http://www.amazon.fr/gp/offer-listing/B00HWX1S54%3FSubscriptionId%3DAKIAILHU4BLBWKCGY46Q%26tag%3Dzwitterion-20%26linkCode%3Dsp1%26camp%3D2025%26creative%3D12742%26creativeASIN%3DB00HWX1S54' (length=188)
          'Offer' => 
            array (size=2)


      'ItemAttributes' => 
        array (size=16)
          'Binding' => string 'VÃªtements' (length=10)
          'Brand' => string 'Yummy Bee' (length=9)
          'ClothingSize' => string '38/40' (length=5)
          'Color' => string 'Noir' (length=4)
          'Department' => string 'femme' (length=5)
          'EAN' => string '5055738416499' (length=13)
          'EANList' => 
            array (size=1)
              ...
          'Feature' => 
            array (size=4)
              ...
          'IsAdultProduct' => boolean false
          'MPN' => string '5055738416499' (length=13)
          'PackageDimensions' => 
            array (size=4)
              ...
          'PartNumber' => string '5055738416499' (length=13)
          'ProductGroup' => string 'Apparel' (length=7)
          'ProductTypeName' => string 'UNDERWEAR' (length=9)
          'Size' => string '38/40' (length=5)
          'Title' => string 'Yummy Bee - Nuisette satin + String + dentelle haut bas Lingerie Sexy - Noir rouge violet - grande taille 38-56 (noir,38-40)' (length=124)



*/

