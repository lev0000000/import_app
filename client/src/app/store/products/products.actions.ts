import { createAction, props } from '@ngrx/store';
import { Product } from '../../models/product';
import { ProductFilters } from '../../models/products-filters';
export const loadProducts = createAction(
  '[Products] Load Products',
  props<{ page: number; limit: number; filters: ProductFilters }>(),
);

export const loadProductsSuccess = createAction(
  '[Products] Load Products Success',
  props<{
    products: Product[];
    total: number;
    totalPages: number;
  }>(),
);

export const loadProductsFailure = createAction(
  '[Products] Load Products Failure',
  props<{ error: string }>(),
);

export const loadProduct = createAction('[Products] Load Product', props<{ id: number }>());

export const loadProductSuccess = createAction(
  '[Products] Load Product Success',
  props<{ product: Product }>(),
);

export const loadProductFailure = createAction(
  '[Products] Load Product Failure',
  props<{ error: string }>(),
);
