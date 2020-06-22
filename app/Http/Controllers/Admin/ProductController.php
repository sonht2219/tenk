<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AuthorizedController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\ProductService;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizedController;

    private ProductService $productService;
    private DtoBuilderService $dtoBuilderService;

    public function __construct(ProductService $productService, DtoBuilderService $dtoBuilderService)
    {
        $this->productService = $productService;
        $this->dtoBuilderService = $dtoBuilderService;
    }

    public function create(ProductRequest $productRequest)
    {
        return $this->dtoBuilderService->buildProductDto(
            $this->productService->createProduct($this->user(), $productRequest)
        );
    }

    public function single($id) {
        return $this->dtoBuilderService->buildProductDto(
            $this->productService->singleProduct($id)
        );
    }

    public function edit($id, ProductRequest $productRequest) {
        return $this->dtoBuilderService->buildProductDto(
            $this->productService->editProduct($id, $productRequest, $this->user())
        );
    }

    public function list(Request $req) {
        $limit = $req->get('limit') ?: 20;
        $search = $req->get('search');
        $status = $req->get('status');

        $page = $this->productService->list($limit, $search, $status);
        return [
            'datas' => collect($page->items())->map(fn($item) => $this->dtoBuilderService->buildProductDto($item)),
            'meta' => get_meta($page)
        ];
    }

    public function delete($id) {
        return $this->dtoBuilderService->buildProductDto(
            $this->productService->delete($id)
        );
    }
}
