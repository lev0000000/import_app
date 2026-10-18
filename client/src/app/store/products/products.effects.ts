import { inject, Service } from '@angular/core';
import { Actions, createEffect, ofType } from '@ngrx/effects';
import { catchError, map, of, switchMap } from 'rxjs';

import * as ProductsActions from './products.actions';
import { Products } from '../../data/services/products/products';

@Service()
export class ProductsEffects {
  private actions$ = inject(Actions);
  private productsService = inject(Products);

  loadProducts$ = createEffect(() =>
    this.actions$.pipe(
      ofType(ProductsActions.loadProducts),

      switchMap(({ page, limit }) =>
        this.productsService.getProducts(page, limit).pipe(
          map(response =>
            ProductsActions.loadProductsSuccess({
              products: response.items,
              total: response.total,
              totalPages: response.totalPages
            })
          ),

          catchError(error =>
            of(ProductsActions.loadProductsFailure({
              error: error.message
            }))
          )
        )
      )
    )
  );
}