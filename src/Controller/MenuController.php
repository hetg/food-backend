<?php

namespace App\Controller;

use App\DTO\DishDto;
use App\DTO\MenuDto;
use App\Entity\Dish;
use App\Entity\Ingredient;
use App\Entity\Menu;
use App\Service\MenuManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;

class MenuController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MenuManager
     */
    private $menuManager;

    public function __construct(EntityManagerInterface $entityManager, MenuManager $menuManager)
    {
        $this->entityManager = $entityManager;
        $this->menuManager = $menuManager;
    }

    /**
     * @ApiDoc\Operation(
     *     tags={"Menus"},
     *     summary="Return list of menus",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @Rest\Get("/menus")
     * @Rest\View()
     *
     * @return array
     */
    public function getMenusAction(): array
    {
        return $this->entityManager->getRepository(Menu::class)->findAll();
    }

    /**
     * @param Menu $menu
     *
     * @ApiDoc\Operation(
     *     tags={"Menus"},
     *     summary="Return menu by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Menu UUID", required=true, type="string"),
     *     @SWG\Response(response="200", description="If successful"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="menu", class="App\Entity\Menu", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Get("/menus/{_uid}")
     * @Rest\View()
     *
     * @return Menu
     */
    public function getMenuAction(Menu $menu): Menu
    {
        return $menu;
    }

    /**
     * @param MenuDto $menuDto
     *
     * @return Menu
     * @ApiDoc\Operation(
     *     tags={"Menus"},
     *     summary="Create menu",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(
     *          name="Menu data",
     *          in="body",
     *          description="Data for creating a menu",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=MenuDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="201", description="Created"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @Rest\Post("/menus")
     * @Rest\View(statusCode=201)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function createMenuAction(MenuDto $menuDto): Menu
    {
        return $this->menuManager->create($menuDto);
    }

    /**
     * @param MenuDto $menuDto
     * @param Menu    $menu
     *
     * @return Menu
     * @ApiDoc\Operation(
     *     tags={"Menus"},
     *     summary="Update menu",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Menu UUID", required=true, type="string"),
     *     @SWG\Parameter(
     *          name="Menu data",
     *          in="body",
     *          description="Data for updating a menu",
     *          type="json",
     *          schema = @SWG\Schema(
     *              type="object",
     *              ref= @ApiDoc\Model(type=MenuDto::class)
     *          )
     *     ),
     *     @SWG\Response(response="202", description="Accepted"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="menu", class="App\Entity\Menu", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Patch("/menus/{_uid}")
     * @Rest\View(statusCode=202)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function updateMenuAction(MenuDto $menuDto, Menu $menu): Menu
    {
        return $this->menuManager->update($menuDto, $menu);
    }

    /**
     * @param Menu    $menu
     *
     * @ApiDoc\Operation(
     *     tags={"Menus"},
     *     summary="Delete menu",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Menu UUID", required=true, type="string"),
     *     @SWG\Response(response="204", description="No Content"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="menu", class="App\Entity\Menu", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Delete("/menus/{_uid}")
     * @Rest\View(statusCode=204)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteMenuAction(Menu $menu)
    {
        $this->menuManager->delete($menu);
    }

    /**
     * @param Menu       $menu
     * @param Dish       $dish
     *
     * @return Menu
     * @ApiDoc\Operation(
     *     tags={"Menus"},
     *     summary="Add dish to menu by UUID",
     *     @SWG\Parameter(name="Authorization", in="header", type="string", description="Authorization token", required=true),
     *     @SWG\Parameter(name="_uid", in="path", description="Menu UUID", required=true, type="string"),
     *     @SWG\Parameter(name="d_uid", in="path", description="Dish UUID", required=true, type="string"),
     *     @SWG\Response(response="202", description="Accepted"),
     *     @SWG\Response(response="400", description="Bad request"),
     *     @SWG\Response(response="401", description="Unauthorized"),
     *     @SWG\Response(response="403", description="Access denied")
     * )
     *
     * @ParamConverter(name="menu", class="App\Entity\Menu", options={"mapping" : {"_uid" : "uniqueIdentifier"}})
     * @ParamConverter(name="dish", class="App\Entity\Dish", options={"mapping" : {"d_uid" : "uniqueIdentifier"}})
     *
     * @Rest\Patch("/menus/{_uid}/dishes/{i_uid}")
     * @Rest\View(statusCode=202)
     *
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function addDishAction(Menu $menu, Dish $dish): Menu
    {
        $menu->addDish($dish);

        $this->entityManager->flush($menu);

        return $menu;
    }

}