import { HttpClient, HttpParams } from '@angular/common/http';
import { inject, Service } from '@angular/core';
import { ProductsResponse } from '../../../models/products-response';
import { ProductFilters } from '../../../models/products-filters';

@Service()
export class Products {
  private http = inject(HttpClient);
  private baseApiUrl = 'http://localhost:8080';

  getProducts(
    page = 1,
    limit = 20,
    filters: ProductFilters = {
      name: '',
      minPrice: null,
      maxPrice: null,
    },
  ) {
    let params = new HttpParams().set('page', page).set('limit', limit);

    if (filters.name.trim()) {
      params = params.set('name', filters.name.trim());
    }

    if (filters.minPrice !== null) {
      params = params.set('minPrice', filters.minPrice);
    }

    if (filters.maxPrice !== null) {
      params = params.set('maxPrice', filters.maxPrice);
    }

    return this.http.get<ProductsResponse>(`${this.baseApiUrl}/api/products`, { params });
  }
}
