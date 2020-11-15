<?php

namespace App\Service;

use App\DTO\MenuDto;
use App\Entity\Menu;
use App\Utils\UuidGenerator;
use Doctrine\ORM\EntityManagerInterface;

class MenuManager
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Create menu method
     *
     * @param MenuDto $menuDto
     *
     * @return Menu
     */
    public function create(MenuDto $menuDto): Menu
    {
        $uuidGenerator = new UuidGenerator();

        $menu = new Menu();
        $menu->setUniqueIdentifier($uuidGenerator->generateUniqueIdentifier());
        $menu->setName($menuDto->name);

        $this->entityManager->persist($menu);
        $this->entityManager->flush($menu);

        return $menu;
    }

    /**
     * Update menu method
     *
     * @param MenuDto $menuDto
     * @param Menu    $menu
     *
     * @return Menu
     */
    public function update(MenuDto $menuDto, Menu $menu): Menu
    {
        $menu->setName($menuDto->name);
        $this->entityManager->flush($menu);

        return $menu;
    }

    /**
     * Delete menu method
     *
     * @param Menu    $menu
     */
    public function delete(Menu $menu): void
    {
        $this->entityManager->remove($menu);
    }
}