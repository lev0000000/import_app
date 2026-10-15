import { HttpClient } from '@angular/common/http';
import { inject, Service } from '@angular/core';

@Service()
export class Import {
  http: HttpClient = inject(HttpClient);

  baseApiUrl = 'http://localhost:8080';

  upload(file: File) {
    const formData = new FormData();
    formData.append('file', file);

    console.log(formData);
    return this.http.post(`${this.baseApiUrl}/api/import`, formData);
  }
}
