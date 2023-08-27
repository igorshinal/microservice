<?php
namespace App\Controller;

use App\DTO\LowestPriceEnquiry;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]

    public function lowestPrice(Request $request, int $id, DTOSerializer $serializer): Response
    {
        if ($request->headers->has('force-fail')) {
            return new JsonResponse([
                ['error' => 'Promosion engeen has fail'],
                $request->headers->get('force_fail')
            ]);
        }

       $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiry::class, 'json', []);
       $lowestPriceEnquiry->setDiscountedPrice(50);
       $lowestPriceEnquiry->setPrice(100);
       $lowestPriceEnquiry->setPromotionId(3);
       $lowestPriceEnquiry->setPromotionName('Black friday half price sale');

       $responseContent = $serializer->serialize($lowestPriceEnquiry, 'json');

       return new Response($responseContent, 200);
    }

    #[Route('/products/{id}/promotions', name: 'promotions', methods: 'GET')]

    public function promotions(): string
    {

    }

    public function invoke(callable $invoker, array $params = []): Response
    {
        $result = $invoker();

        return new JsonResponse([
            'quantity' => 5,
            'request_location' => 'UK',
            'voucher_code' => 'OU812',
            'request_date' => '2022-13-14',
            'product_id' => $result,
        ]);
    }
}