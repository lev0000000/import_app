import { createReducer, on } from '@ngrx/store';
import { Product } from '../../models/product';
import * as ProductsActions from './products.actions';

export interface ProductsState {
  products: Product[];
  loading: boolean;
  total: number;
  totalPages: number;
  error: string | null;
}

export const initialState: ProductsState = {
  products: [],
  loading: false,
  total: 0,
  totalPages: 0,
  error: null
};

export const productsReducer = createReducer(
  initialState,

  on(ProductsActions.loadProducts, state => ({
    ...state,
    loading: true,
    error: null
  })),

  on(ProductsActions.loadProductsSuccess, (state, { products, total, totalPages }) => ({
    ...state,
    products,
    total,
    totalPages,
    loading: false
  })),

  on(ProductsActions.loadProductsFailure, (state, { error }) => ({
    ...state,
    loading: false,
    error
  }))
);