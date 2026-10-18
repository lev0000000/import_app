import { createAction, props } from '@ngrx/store';
import { Product } from '../../models/product';

export const loadProducts = createAction(
  '[Products] Load Products',
  props<{ page: number; limit: number }>()
);

export const loadProductsSuccess = createAction(
  '[Products] Load Products Success',
  props<{
    products: Product[];
    total: number;
    totalPages: number;
  }>()
);

export const loadProductsFailure = createAction(
  '[Products] Load Products Failure',
  props<{ error: string }>()
);