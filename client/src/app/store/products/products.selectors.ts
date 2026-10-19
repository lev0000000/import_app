
import { createFeatureSelector, createSelector } from '@ngrx/store';
import { ProductsState } from './products.reducer';

export const selectProductsState =
  createFeatureSelector<ProductsState>('products');

export const selectAllProducts = createSelector(
  selectProductsState,
  state => state.products
);

export const selectProductsLoading = createSelector(
  selectProductsState,
  state => state.loading
);

export const selectTotalPages = createSelector(
  selectProductsState,
  state => state.totalPages
);

export const selectProduct = createSelector(
  selectProductsState,
  state => state.product
);

export const selectProductLoading = createSelector(
  selectProductsState,
  state => state.productLoading
);

export const selectProductsError = createSelector(
  selectProductsState,
  state => state.error
);
