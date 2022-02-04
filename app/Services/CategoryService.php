<?php

namespace App\Services;

use App\Repositories\CategoryRepository;


class CategoryService
{
    /**
     * @var $CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Category constructor
     * 
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all category.
     * 
     */
    public function getAllCategory()
    {
        return $this->categoryRepository->getAll();
    }

    /**
     * Get count of all category.
     * 
     */
    public function getCountAllCategory()
    {
        $result = $this->categoryRepository->countAll();

        return $result;
    }

}