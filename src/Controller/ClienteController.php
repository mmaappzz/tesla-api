<?php

namespace App\Controller;

use App\Entity\Cliente;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    /*#[Route('/cliente', name: 'app_cliente')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ClienteController.php',
        ]);
    }*/
	#[Route('/cliente/{id}', name: 'cliente_show')]
	public function show(ManagerRegistry $doctrine, int $id): JsonResponse
	{
		$cliente = $doctrine->getRepository(Cliente::class)->find($id);

		if (!$cliente) {
			throw $this->createNotFoundException(
				'No product found for id '.$id
			);
		}

		return new JsonResponse($this->json($cliente));

		// or render a template
		// in the template, print things with {{ product.name }}
		// return $this->render('product/show.html.twig', ['product' => $product]);
	}
	#[Route('/cliente', name: 'create_cliente')]
	public function createCliente(ManagerRegistry $doctrine): Response 	{
		$entityManager = $doctrine->getManager();

		$cliente = new Cliente();
		$cliente->setNombre(null);
		$cliente->setCuit(1999);
		$cliente->setMail('mariano@perez.com');

		// tell Doctrine you want to (eventually) save the Product (no queries yet)
		$entityManager->persist($cliente);

		// actually executes the queries (i.e. the INSERT query)
		$entityManager->flush();

		return new Response('Saved new product with id '.$cliente->getId());
	}
}
