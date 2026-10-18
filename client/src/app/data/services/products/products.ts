import { HttpClient, HttpParams } from '@angular/common/http';
import { inject, Service } from '@angular/core';
import { ProductsResponse } from '../../../models/products-response';


@Service()
export class Products {
  private http = inject(HttpClient);
  private baseApiUrl = 'http://localhost:8080';

  getProducts(page = 1, limit = 20) {
    const params = new HttpParams()
      .set('page', page)
      .set('limit', limit);

    return this.http.get<ProductsResponse>(
      `${this.baseApiUrl}/api/products`,
      { params }
    );
  }
}