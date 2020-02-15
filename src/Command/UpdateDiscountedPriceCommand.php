<?php 

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\DiscountRule;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class UpdateDiscountedPriceCommand extends Command
{
   private $em;
   
   public function __construct(EntityManagerInterface $em)
   {
       parent::__construct();
        $this->em = $em;
   }
   
    protected static $defaultName = 'app:update-discounted-price-products';

    protected function configure()
    {
        $this->setDescription('Updates all products discounted prices');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Products discounted prices updater');

        $discountRules = $this->em->getRepository(DiscountRule::class)->findAll();
        foreach ($discountRules as $discountRule)
        {
            $discountRuleLanguage = new ExpressionLanguage();
            $expression = 'type in ["'.$discountRule->getType().'"] and price '.$discountRule->getRuleExpression().' '.$discountRule->getPriceLimit();
            $products =  $this->em->getRepository(Product::class)->findAll();
           
           foreach ($products as $product)
           {
               $productInfo = array(
                   'type' => $product->getType(),
                   'price' => $product->getPrice()
               );
               
               $isUpdatable = $discountRuleLanguage->evaluate(
                   $expression,
                   $productInfo
               );
               
               if ($isUpdatable)
               {
                   $reduction = $product->getPrice() * ($discountRule->getdiscountPercent()/100);
                   $product->setDiscoutedPrice($product->getPrice()-$reduction);
               }
           }
        }
        
        $this->em->flush();
        $output->write('Done');
        return 0;
    }
}