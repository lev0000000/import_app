import { inject, Injectable } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import { catchError, map, of, switchMap } from 'rxjs';

import * as ProductsActions from './products.actions';
import { Products } from '../../data/services/products/products';
import { ProductItem } from '../../data/services/product-item/product-item';

@Injectable()
export class ProductsEffects {
  private actions$ = inject(Actions);
  private productsService = inject(Products);
  private productService = inject(ProductItem);

  loadProducts$ = createEffect(() =>
    this.actions$.pipe(
      ofType(ProductsActions.loadProducts),
      switchMap(({ page, limit, filters }) =>
        this.productsService.getProducts(page, limit, filters).pipe(
          map((response) =>
            ProductsActions.loadProductsSuccess({
              products: response.items,
              total: response.total,
              totalPages: response.totalPages,
            }),
          ),
          catchError((error) =>
            of(
              ProductsActions.loadProductsFailure({
                error: error.message,
              }),
            ),
          ),
        ),
      ),
    ),
  );

  loadProduct$ = createEffect(() =>
    this.actions$.pipe(
      ofType(ProductsActions.loadProduct),
      switchMap(({ id }) =>
        this.productService.getProduct(id).pipe(
          map((product) => ProductsActions.loadProductSuccess({ product })),
          catchError((error) =>
            of(
              ProductsActions.loadProductFailure({
                error: error.message,
              }),
            ),
          ),
        ),
      ),
    ),
  );
}
